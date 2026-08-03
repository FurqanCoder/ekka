<?php

namespace App\Livewire\Dashboard\Settings;

use App\Models\CarouselItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DesignComponent extends Component
{
    use WithFileUploads;

    public $carouselItems = [];
    public $newItems = [];
    public $editMode = false;
    public $editingId = null;
    
    // Validation rules
    protected $rules = [
        'carouselItems.*.title' => 'required|string|max:255',
        'carouselItems.*.offer_label' => 'nullable|string|max:255',
        'carouselItems.*.discount_badge' => 'nullable|string|max:255',
        'carouselItems.*.description' => 'nullable|string|max:1000',
        'carouselItems.*.button_link' => 'nullable|url|max:500',
        'carouselItems.*.button_text' => 'nullable|string|max:100',
        'carouselItems.*.status' => 'required|in:active,inactive,draft',
        'carouselItems.*.image' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'carouselItems.*.title.required' => 'Title is required',
        'carouselItems.*.image.image' => 'File must be an image',
        'carouselItems.*.image.max' => 'Image size must not exceed 2MB',
        'carouselItems.*.button_link.url' => 'Please enter a valid URL',
    ];

    // Real-time validation
    protected function getValidationAttributes()
    {
        $attributes = [];
        foreach ($this->carouselItems as $index => $item) {
            $attributes["carouselItems.{$index}.title"] = "Item #" . ($index + 1) . " Title";
            $attributes["carouselItems.{$index}.offer_label"] = "Item #" . ($index + 1) . " Offer Label";
            $attributes["carouselItems.{$index}.discount_badge"] = "Item #" . ($index + 1) . " Discount Badge";
            $attributes["carouselItems.{$index}.description"] = "Item #" . ($index + 1) . " Description";
            $attributes["carouselItems.{$index}.button_link"] = "Item #" . ($index + 1) . " Button Link";
            $attributes["carouselItems.{$index}.button_text"] = "Item #" . ($index + 1) . " Button Text";
            $attributes["carouselItems.{$index}.status"] = "Item #" . ($index + 1) . " Status";
            $attributes["carouselItems.{$index}.image"] = "Item #" . ($index + 1) . " Image";
        }
        return $attributes;
    }

    public function mount()
    {
        $this->loadCarouselItems();
    }

    public function loadCarouselItems()
    {
        $items = CarouselItem::ordered()->get();
        
        if ($items->isEmpty()) {
            // Create a default empty item
            $this->carouselItems = [
                [
                    'id' => null,
                    'title' => '',
                    'offer_label' => '',
                    'discount_badge' => '',
                    'description' => '',
                    'button_link' => '',
                    'button_text' => 'Shop Now',
                    'status' => 'active',
                    'image' => null,
                    'existing_image' => null,
                    'is_new' => true,
                ]
            ];
        } else {
            $this->carouselItems = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'offer_label' => $item->offer_label,
                    'discount_badge' => $item->discount_badge,
                    'description' => $item->description,
                    'button_link' => $item->button_link,
                    'button_text' => $item->button_text,
                    'status' => $item->status,
                    'image' => null,
                    'existing_image' => $item->image_path,
                    // Ensure we always provide a usable URL for the view. If the accessor is null
                    // (rare), fall back to generating a storage URL from the stored path.
                    'image_url' => $item->image_url ?: ($item->image_path ? Storage::disk('public')->url($item->image_path) : null),
                    'is_new' => false,
                ];
            })->toArray();
        }
    }

    public function addCarouselItem()
    {
        $this->carouselItems[] = [
            'id' => null,
            'title' => '',
            'offer_label' => '',
            'discount_badge' => '',
            'description' => '',
            'button_link' => '',
            'button_text' => 'Shop Now',
            'status' => 'active',
            'image' => null,
            'existing_image' => null,
            'image_url' => null,
            'is_new' => true,
        ];

        $this->dispatch('itemAdded');
    }

    public function removeCarouselItem($index)
    {
        if (count($this->carouselItems) <= 1) {
            $this->dispatch('notification', [
                'message' => 'Cannot remove the last item. At least one item is required.',
                'type' => 'warning'
            ]);
            return;
        }

        $item = $this->carouselItems[$index];
        
        // If it's an existing item from database, delete it
        if (isset($item['id']) && $item['id'] && !$item['is_new']) {
            try {
                $carouselItem = CarouselItem::find($item['id']);
                if ($carouselItem) {
                    $carouselItem->delete();
                }
            } catch (\Exception $e) {
                Log::error('Error deleting carousel item: ' . $e->getMessage());
                $this->dispatch('notification', [
                    'message' => 'Error deleting item. Please try again.',
                    'type' => 'error'
                ]);
                return;
            }
        }

        array_splice($this->carouselItems, $index, 1);
        
        $this->dispatch('notification', [
            'message' => 'Item removed successfully!',
            'type' => 'success'
        ]);
    }

    public function editItem($index)
    {
        $this->editMode = true;
        $this->editingId = $index;
        
        // Enable editing mode for this specific item
        $this->dispatch('enableEditing', ['index' => $index]);
    }

    public function saveEdit($index)
    {
        $this->validate([
            "carouselItems.{$index}.title" => 'required|string|max:255',
            "carouselItems.{$index}.button_link" => 'nullable|url|max:500',
        ]);

        $item = $this->carouselItems[$index];
        
        if (isset($item['id']) && $item['id']) {
            // Update existing item
            try {
                $carouselItem = CarouselItem::find($item['id']);
                if ($carouselItem) {
                    $updateData = [
                        'title' => $item['title'],
                        'offer_label' => $item['offer_label'],
                        'discount_badge' => $item['discount_badge'],
                        'description' => $item['description'],
                        'button_link' => $item['button_link'],
                        'button_text' => $item['button_text'],
                        'status' => $item['status'],
                    ];

                    // Handle image upload
                    if (isset($item['image']) && $item['image']) {
                        $path = $item['image']->store('carousel', 'public');
                        $updateData['image_path'] = $path;
                    }

                    $carouselItem->update($updateData);
                    
                    // Update the carouselItems array with the new data
                    $this->carouselItems[$index]['id'] = $carouselItem->id;
                    $this->carouselItems[$index]['is_new'] = false;
                    if (isset($item['image']) && $item['image']) {
                        $this->carouselItems[$index]['existing_image'] = $path;
                        $this->carouselItems[$index]['image_url'] = Storage::disk('public')->url($path);
                        $this->carouselItems[$index]['image'] = null;
                    }

                    $this->dispatch('notification', [
                        'message' => 'Item updated successfully!',
                        'type' => 'success'
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error updating carousel item: ' . $e->getMessage());
                $this->dispatch('notification', [
                    'message' => 'Error updating item. Please try again.',
                    'type' => 'error'
                ]);
                return;
            }
        }

        $this->editMode = false;
        $this->editingId = null;
        $this->dispatch('editingDisabled');
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->editingId = null;
        $this->dispatch('editingDisabled');
    }

    public function saveAllItems()
    {
        try {
            $this->validate();

            foreach ($this->carouselItems as $index => $item) {
                if ($item['is_new']) {
                    // Create new item
                    $data = [
                        'title' => $item['title'],
                        'offer_label' => $item['offer_label'],
                        'discount_badge' => $item['discount_badge'],
                        'description' => $item['description'],
                        'button_link' => $item['button_link'],
                        'button_text' => $item['button_text'],
                        'status' => $item['status'],
                        'created_by' => auth()->id(),
                    ];

                    // Handle image upload for new item
                    if (isset($item['image']) && $item['image']) {
                        $path = $item['image']->store('carousel', 'public');
                        $data['image_path'] = $path;
                    }

                    $carouselItem = CarouselItem::create($data);
                    
                    // Update the carouselItems array
                    $this->carouselItems[$index]['id'] = $carouselItem->id;
                    $this->carouselItems[$index]['is_new'] = false;
                    if (isset($item['image']) && $item['image']) {
                        $this->carouselItems[$index]['existing_image'] = $path;
                        $this->carouselItems[$index]['image_url'] = Storage::disk('public')->url($path);
                        $this->carouselItems[$index]['image'] = null;
                    }
                }
            }

            $this->dispatch('notification', [
                'message' => 'All items saved successfully!',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saving carousel items: ' . $e->getMessage());
            $this->dispatch('notification', [
                'message' => 'Error saving items. Please check your inputs.',
                'type' => 'error'
            ]);
        }
    }

    public function resetAllItems()
    {
        $this->loadCarouselItems();
        $this->dispatch('notification', [
            'message' => 'All items have been reset!',
            'type' => 'info'
        ]);
    }

    public function updated($propertyName, $value)
    {
        // Handle real-time validation for specific fields
        if (str_starts_with($propertyName, 'carouselItems.')) {
            $parts = explode('.', $propertyName);
            $index = $parts[1];
            $field = $parts[2];
            
            // Validate URL in real-time
            if ($field === 'button_link' && $value) {
                $this->validateOnly($propertyName);
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard.settings.design-component')
            ->extends('layouts.admin')
            ->section('admin-content');
    }
}