<?php

namespace App\Livewire\Dashboard\ProductTabs;

use Livewire\Component;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Livewire\WithFileUploads;
use Cloudinary\Api\Exception\ApiError;
use Illuminate\Support\Facades\Log;

class VariantsTab extends Component
{
    use WithFileUploads;

    public $hasVariants = true;
    public $options = []; // Example: [['option_id' => 1, 'values' => [2,3]]]
    public $variants = [];

    public $allOptions = []; // DB Options
    public $allValues = [];  // Values grouped by option_id

    public function mount($variants = [])
    {
        $this->allOptions = ProductOption::all()->toArray();
        $this->allValues  = ProductOptionValue::all()
            ->groupBy('product_option_id')
            ->toArray();

        if (!empty($variants)) {
            $this->variants = collect($variants)->map(function ($variant) {
                $labelParts = [];

                foreach ($variant['value_ids'] as $valueId) {
                    $value = collect($this->allValues)
                        ->flatten(1)
                        ->firstWhere('id', $valueId);

                    if ($value) {
                        $option = collect($this->allOptions)
                            ->firstWhere('id', $value['product_option_id']);

                        if ($option) {
                            $labelParts[] = $option['name'] . ':' . $value['value'];
                        }
                    }
                }

                return [
                    'id'        => $variant['id'] ?? null,
                    'label'     => implode(' | ', $labelParts),
                    'sku'       => $variant['sku'] ?? '',
                    'price'     => $variant['price'] ?? 0,
                    'cost'      => $variant['cost'] ?? 0,
                    'stock'     => $variant['stock'] ?? 0,
                    'image'     => $variant['image'] ?? null, // URL or temporary uploaded file
                    'public_id' => $variant['public_id'] ?? null,
                    'active'    => $variant['active'] ?? true,
                    'value_ids' => $variant['value_ids'] ?? [],
                ];
            })->toArray();
        }
    }

    public function addOption()
    {
        $this->options[] = ['option_id' => null, 'values' => []];
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function generateVariants()
    {
        if (empty($this->options)) {
            $this->variants = [];
            return;
        }

        $optNames = [];
        $optValues = [];

        foreach ($this->options as $opt) {
            $option = collect($this->allOptions)->firstWhere('id', $opt['option_id']);
            if (!$option) continue;

            $optNames[] = $option['name'];

            $selectedValues = array_filter($opt['values']);
            $valueLabels = [];
            foreach ($selectedValues as $valueId) {
                $val = collect($this->allValues[$opt['option_id']] ?? [])->firstWhere('id', $valueId);
                if ($val) {
                    $valueLabels[] = [
                        'id'    => $val['id'],
                        'label' => $val['value']
                    ];
                }
            }

            $optValues[] = $valueLabels;
        }

        $combinations = $this->cartesian($optValues);

        $newVariants = [];
        foreach ($combinations as $combo) {
            $labelParts = [];
            $valueIds   = [];

            foreach ($combo as $idx => $val) {
                $labelParts[] = $optNames[$idx] . ':' . $val['label'];
                $valueIds[]   = $val['id'];
            }

            $label = implode(' | ', $labelParts);

            // Preserve existing data
            $existing = collect($this->variants)->firstWhere('label', $label);

            $newVariants[] = [
                'label'     => $label,
                'value_ids' => $valueIds,
                'sku'       => $existing['sku'] ?? '',
                'price'     => $existing['price'] ?? 0,
                'cost'      => $existing['cost'] ?? 0,
                'stock'     => $existing['stock'] ?? 0,
                'image'     => $existing['image'] ?? null,
                'public_id' => $existing['public_id'] ?? null,
                'active'    => $existing['active'] ?? true,
            ];
        }

        $this->variants = $newVariants;
    }

    private function cartesian($arrays)
    {
        $result = [[]];
        foreach ($arrays as $propertyValues) {
            $tmp = [];
            foreach ($result as $resultItem) {
                foreach ($propertyValues as $propertyValue) {
                    $tmp[] = array_merge($resultItem, [$propertyValue]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    // ------------------------------
    // IMAGE HANDLING / DELETION
    // ------------------------------

    /**
     * Livewire hook: when a file is uploaded to a variants.*.image property,
     * delete previous saved image (if any) immediately from Cloudinary.
     */
    public function updated($propertyName, $value)
    {
        // detect variants.X.image updates
        if (preg_match('/^variants\.(\d+)\.image$/', $propertyName, $matches)) {
            $index = (int)$matches[1];

            // New value is a Livewire temporary uploaded file?
            if (is_object($value) &&
                ( $value || $value  )) {

                $prevPublic = $this->variants[$index]['public_id'] ?? null;

                if ($prevPublic) {
                    try {
                        $cloudinary = app('cloudinary.account.two');
                        $cloudinary->uploadApi()->destroy($prevPublic);
                        Log::info("Deleted previous variant image: {$prevPublic}");
                    } catch (ApiError $e) {
                        Log::error("Cloudinary delete failed in updated(): " . $e->getMessage());
                        session()->flash('error', 'Failed to remove previous image from Cloudinary.');
                    }

                    // Clear stored public_id and let 'image' be the temporary upload
                    $this->variants[$index]['public_id'] = null;
                    // notify parent/listeners
                    $this->dispatch('variantsUpdated', $this->variants);
                }
            }
        }
    }

    /**
     * Remove image for a variant (called by delete button).
     * Works for both preview (temporary upload) and saved images (Cloudinary).
     */
    public function removeVariantImage($index)
{
    if (!isset($this->variants[$index])) {
        return;
    }

    $image = $this->variants[$index]['image'] ?? null;
    $publicId = $this->variants[$index]['public_id'] ?? null;

    // If it's a temporary upload -> just remove preview
    if (is_object($image) && $image) {
        $this->variants[$index]['image'] = null;
        session()->flash('success', 'Preview removed.');
        $this->dispatch('variantsUpdated', $this->variants);
        return;
    }

    // Otherwise, delete from Cloudinary using public_id
    if ($publicId) {
        try {
            $cloudinary = app('cloudinary.account.two');
            $cloudinary->uploadApi()->destroy($publicId);
        } catch (\Cloudinary\Api\Exception\ApiError $e) {
            Log::error("Cloudinary delete failed in removeVariantImage(): " . $e->getMessage());
            session()->flash('error', 'Cloudinary delete failed. Please try again later.');
            return;
        }
    }

    // Clear state
    $this->variants[$index]['image'] = null;
    $this->variants[$index]['public_id'] = null;
    session()->flash('success', 'Image removed.');
    $this->dispatch('variantsUpdated', $this->variants);
}


    /**
     * Helper: try to extract public_id from a Cloudinary secure_url
     * Example: https://res.cloudinary.com/demo/image/upload/v1690000000/thumbnail/sample.jpg
     * returns: thumbnail/sample
     */
    private function extractPublicIdFromUrl($url)
    {
        if (!$url) return null;
        $parsed = parse_url($url);
        if (!$parsed || !isset($parsed['path'])) return null;
        $path = $parsed['path']; // e.g. /demo/image/upload/v169.../thumbnail/sample.jpg
        $pos = strpos($path, '/upload/');
        if ($pos === false) return null;
        $sub = substr($path, $pos + strlen('/upload/')); // v1234/thumbnail/sample.jpg
        // remove version prefix like v123456/
        $sub = preg_replace('#^v[0-9]+/#', '', $sub);
        // remove extension
        $publicId = preg_replace('/\.[^.]+$/', '', $sub);
        return ltrim($publicId, '/');
    }

    // ------------------------------
    // SAVE
    // ------------------------------
    public function saveVariants()
    {
        foreach ($this->variants as $i => $variant) {
            // If image is a temporary upload -> upload to Cloudinary
            if (isset($variant['image']) &&
                is_object($variant['image']) &&
                ($variant['image'] || $variant['image'] )) {

                // Edge-case: if public_id still set for some reason, delete it first
                $prevPublic = $this->variants[$i]['public_id'] ?? null;
                if ($prevPublic) {
                    try {
                        $cloudinary = app('cloudinary.account.two');
                        $cloudinary->uploadApi()->destroy($prevPublic);
                    } catch (ApiError $e) {
                        Log::error("Cloudinary delete failed in saveVariants(): " . $e->getMessage());
                        // don't abort saving; continue to upload new one
                    }
                }

                // Upload the new file
                $cloudinary = app('cloudinary.account.two');
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $variant['image']->getRealPath(),
                    ['folder' => 'variants', 'resource_type' => 'image']
                );

                $this->variants[$i]['image'] = $uploadResult['secure_url'] ?? null;
                $this->variants[$i]['public_id'] = $uploadResult['public_id'] ?? null;
            }
        }

        // Broadcast updated variants to parent/consumer for persistence
        $this->dispatch('variantsUpdated', $this->variants);
        session()->flash('success', 'Variants saved successfully!');
    }

    public function refreshMe()
    {
        // Use dispatch so parent/listeners can respond; keep consistent with events used above
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.dashboard.product-tabs.variants-tab', [
            'allOptions' => $this->allOptions,
            'allValues'  => $this->allValues,
            'options'    => $this->options,
            'variants'   => $this->variants,
        ]);
    }
}
