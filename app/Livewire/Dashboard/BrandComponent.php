<?php

namespace App\Livewire\Dashboard;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Cloudinary\Api\Exception\ApiError;
use Illuminate\Support\Facades\Log;

class BrandComponent extends Component
{
    use WithFileUploads;

    // Form fields
    public $brandId;
    public $name;
    public $description;
    public $logo;
    public $existingLogo;
    public $existingPublicId;
    public $metaTitle;
    public $metaDescription;
    public $metaKeywords;

    // UI State
    public $buttonText = "Add New Brand";
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->resetForm();
    }

    /** ✅ Validation Rules */
    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255|unique:brands,name,' . $this->brandId,
            'description' => 'required|string|max:255',
            'logo' => $this->brandId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'metaTitle' => 'nullable|string|max:255',
            'metaDescription' => 'nullable|string|max:500',
            'metaKeywords' => 'nullable|string|max:255',
        ];
    }

    /** ✅ Reset Form */
    private function resetForm()
    {
        $this->reset([
            'brandId', 'name', 'description', 'logo', 'existingLogo',
            'existingPublicId', 'metaTitle', 'metaDescription', 'metaKeywords'
        ]);
        $this->buttonText = "Add New Brand";
    }

    /** ✅ Store New Brand */
    public function store()
    {
        $this->validate();

        $data = $this->formData();

        $brand = new Brand();
        $brand->fill($data);
        $brand->save();

        $this->resetForm();
        $this->dispatch('close-modal');
        $this->dispatch('toast', 'Brand created successfully!', 'success');
    }

    /** ✅ Update Brand */
    public function update()
    {
        $this->validate();

        $brand = Brand::find($this->brandId);
        if (!$brand) {
            return $this->dispatch('toast', 'Brand not found!', 'error');
        }

        $data = $this->formData($brand);

        $brand->fill($data);
        $brand->save();

        $this->resetForm();
        $this->dispatch('close-modal');
        $this->dispatch('toast', 'Brand updated successfully!', 'success');
    }

    /** ✅ Prepare Form Data + Handle Cloudinary */
    private function formData($brand = null)
    {
        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
        ];

        $cloudinary = app('cloudinary.account.one');

        // Handle logo
        if ($this->logo && !is_string($this->logo)) {
            // Delete old logo if updating
            if ($brand && $brand->public_id) {
                try {
                    $cloudinary->uploadApi()->destroy($brand->public_id);
                } catch (ApiError $e) {
                    Log::error("Cloudinary delete failed (update brand): " . $e->getMessage());
                }
            }

            // Upload new logo
            $uploadResult = $cloudinary->uploadApi()->upload(
                $this->logo->getRealPath(),
                [
                    'folder' => 'brands',
                    'resource_type' => 'image',
                ]
            );

            $data['logo'] = $uploadResult['secure_url'];
            $data['public_id'] = $uploadResult['public_id'];
        } else {
            // Keep old logo/public_id if not uploading new one
            $data['logo'] = $brand->logo ?? $this->existingLogo ?? null;
            $data['public_id'] = $brand->public_id ?? $this->existingPublicId ?? null;
        }

        return $data;
    }

    /** ✅ Edit Brand */
    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return $this->dispatch('toast', 'Brand not found!', 'error');
        }

        $this->brandId = $id;
        $this->name = $brand->name;
        $this->description = $brand->description;
        $this->existingLogo = $brand->logo;
        $this->existingPublicId = $brand->public_id;
        $this->metaTitle = $brand->meta_title;
        $this->metaDescription = $brand->meta_description;
        $this->metaKeywords = $brand->meta_keywords;
        $this->buttonText = "Update Brand";

        $this->dispatch('open-modal');
    }

    /** ✅ Delete Brand + Logo */
    public function delete($id)
    {
        if ($brand = Brand::find($id)) {
            if ($brand->public_id) {
                try {
                    $cloudinary = app('cloudinary.account.one');
                    $cloudinary->uploadApi()->destroy($brand->public_id);
                } catch (ApiError $e) {
                    Log::error("Cloudinary delete failed (delete brand): " . $e->getMessage());
                }
            }

            $brand->delete();
            $this->dispatch('toast', 'Brand deleted successfully!', 'info');
        } else {
            $this->dispatch('toast', 'Brand not found!', 'error');
        }
    }

    /** ✅ Toggle Status */
    public function toggle($id)
    {
        if ($brand = Brand::find($id)) {
            $brand->status = $brand->status === 'active' ? 'inactive' : 'active';
            $brand->save();
            $this->dispatch('toast', 'Brand status updated!', 'info');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.brand-component', [
            'brands' => Brand::latest()->get()
        ])->extends('layouts.admin')->section('admin-content');
    }
}
