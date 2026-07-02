<?php

namespace App\Livewire\Dashboard;

use App\Models\{
    Brand,
    Category,
    Product,
    ProductCategory,
    ProductIngredients,
    ProductInstruction,
    ProductMedia,
    ProductPrice,
    ProductTags,
    ProductVariant,
    ProductVariantValue,
    Tag
};
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Cloudinary\Api\Exception\ApiError;

class AddProductComponent extends Component
{
    use WithFileUploads;
    public $productId = null; // detect edit mode

    // UI state
    public $activeTab = 'general';

    // rich text
    // public $des = "hello";
    // public $tx = "how to use";
    public $description = '';
    public $howtouse  = '';

    // general
    public $name;
    public $slug;
    public $brand;
    public $status = 'draft';
    public $schedule_time;

    // media
    public $thumbnail;       // single file
    public $gallery = [];    // multiple files

    // pricing
    public $c_price = 0;
    public $b_price = 0;
    public $discountType = 'none'; // none|percent|fixed
    public $d_value = 0;
    public $taxType = 'tax_free'; // tax_free|taxable|digital
    public $vat = 0;
    public $f_price = 0;
    public $a_profit = 0;

    // inventory
    public $sku;
    public $track_stock = false;
    public $quantity = 0;

    // variants
    public $variants = [];

    // categories & tags
    public $categories = [];
    public $subcategories = [];
    public $selectedParent = null;
    public $selectedTags = [];

    // instructions
    public $ins_media; // single file (image or video)
    public $ins_url;
    // ingredients
    public $ingredients = [];

    // seo
    public $meta_title;
    public $meta_des;
    public $meta_keywords;

    protected $listeners = [
        'ingredientsUpdated' => 'setIngredients',
        'variantsUpdated'    => 'setVariants',
    ];

    protected function rules()
    {
        return [
            // General
            'name'  => 'required|string|max:255',
            'slug'  => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($this->productId),
            ],
            'description' => 'nullable|string|max:5000',
            'brand'       => 'nullable|exists:brands,id',
            'status'      => 'required|in:live,draft,scheduled,inactive',
            'schedule_time' => 'nullable|date|after_or_equal:today',

            // Pricing
            'c_price'      => 'nullable|numeric|min:0',
            'b_price'      => 'required|numeric|min:0',
            'discountType' => 'nullable|in:none,percent,fixed',
            'd_value'      => 'nullable|numeric|min:0',
            'taxType'      => 'nullable|in:tax_free,taxable,digital',
            'vat'          => 'nullable|numeric|min:0|max:100',
            'f_price'      => 'nullable|numeric|min:0',
            'a_profit'     => 'nullable|numeric|min:0',

            // Inventory
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($this->productId),
            ],
            'track_stock' => 'boolean',
            'quantity'    => 'nullable|integer|min:0',

            // Media
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            // Tags
            'selectedTags'   => 'array',
            'selectedTags.*' => 'exists:tags,id',

            // Instructions
            'howtouse'  => 'nullable|string|max:3000',
            'ins_media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:51200',

            // SEO
            'meta_title'    => 'nullable|string|max:255',
            'meta_des'      => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',

            // Ingredients
            'ingredients'               => 'array',
            'ingredients.*.ingredient'  => 'required|string|max:255',
            'ingredients.*.percentage'  => 'nullable|numeric|min:0|max:100',
            'ingredients.*.benefit'     => 'nullable|string|max:500',

            // Variants
            'variants'                 => 'array',
            'variants.*.sku'           => 'required|string|max:100|distinct',
            'variants.*.price'         => 'required|numeric|min:0',
            'variants.*.stock'         => 'nullable|integer|min:0',
            'variants.*.value_ids'     => 'array',
            'variants.*.value_ids.*'   => 'required|exists:product_option_values,id',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();

            $product = $this->productId
                ? Product::findOrFail($this->productId)
                : new Product();

            // fill product fields
            $product->fill([
                'name'        => $validated['name'],
                'slug'        => $validated['slug'] ?? null,
                'description' => $validated['description'] ?? null,
                'brand_id'    => $validated['brand'] ?? null,
                'status'      => $validated['status'],
                'scheduled_at' => $validated['schedule_time'] ?? null,
                'sku'         => $validated['sku'] ?? null,
                'track'       => $this->track_stock ?? false,
                'stock'       => $validated['quantity'] ?? 0,
                'meta_title'  => $validated['meta_title'] ?? null,
                'meta_description' => $validated['meta_des'] ?? null,
                'meta_keywords'    => $validated['meta_keywords'] ?? null,
            ]);
            $product->save();

            /**
             * 🔹 Media: Thumbnail + Gallery
             */
            if ($this->thumbnail) {
                $cloudinary = app('cloudinary.account.two');
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $this->thumbnail->getRealPath(),
                    ['folder' => 'thumbnail', 'resource_type' => 'image']
                );

                ProductMedia::updateOrCreate(
                    ['product_id' => $product->id, 'is_thumbnail' => true],
                    ['type' => 'image', 'file_path' => $uploadResult['secure_url'] ?? null, 'public_id' => $uploadResult['public_id']]
                );
            }

            if ($this->gallery && count($this->gallery)) {
                // delete old gallery if updating
                ProductMedia::where('product_id', $product->id)->where('is_thumbnail', false)->delete();

                foreach ($this->gallery as $file) {
                    $cloudinary = app('cloudinary.account.two');
                    $uploadResult = $cloudinary->uploadApi()->upload(
                        $file->getRealPath(),
                        ['folder' => 'gallery', 'resource_type' => 'image']
                    );

                    ProductMedia::create([
                        'product_id'  => $product->id,
                        'type'        => 'image',
                        'is_thumbnail' => false,
                        'file_path'   => $uploadResult['secure_url'] ?? null,
                        'public_id'   => $uploadResult['public_id'] ?? null,
                    ]);
                }
            }

            /**
             * 🔹 Price
             */
            if ($this->b_price) {
                ProductPrice::updateOrCreate(
                    ['product_id' => $product->id],
                    [
                        'cost_price'      => $validated['c_price'] ?? 0,
                        'base_price'      => $validated['b_price'],
                        'discount_type'   => $validated['discountType'] ?? 'none',
                        'discount_value'  => $validated['d_value'] ?? 0,
                        'tax_class'       => $validated['taxType'] ?? 'tax_free',
                        'vat_percent'     => $validated['vat'] ?? 0,
                        'final_price'     => $validated['f_price'] ?? 0,
                        'assuming_profit' => $validated['a_profit'] ?? 0,
                    ]
                );
            }

            /**
             * 🔹 Instructions
             */
            if (($this->howtouse && strlen($this->howtouse) > 0) || $this->ins_media) {
                $ins = ProductInstruction::firstOrNew(['product_id' => $product->id]);
                $ins->content = $this->howtouse;
                if ($this->ins_media) {
                    $cloudinary = app('cloudinary.account.two');
                    $resourceType = str_starts_with($this->ins_media->getMimeType(), 'video') ? 'video' : 'image';

                    $uploadResult = $cloudinary->uploadApi()->upload(
                        $this->ins_media->getRealPath(),
                        ['folder' => 'instructions', 'resource_type' => $resourceType]
                    );
                    $ins->url = $uploadResult['secure_url'] ?? null;
                    $ins->file_path = $uploadResult['public_id'] ?? null;
                    $ins->type = $resourceType;
                } elseif ($this->ins_url) {
                    $ins->url = $this->ins_url;
                }
                $ins->save();
            }

            /**
             * 🔹 Tags (sync instead of creating duplicates)
             */
            $tags = $validated['selectedTags'] ?? $this->selectedTags;
            if ($tags && count($tags)) {
                $product->tags()->sync($tags);
            }

            /**
             * 🔹 Categories (sync parent + child)
             */
            if ($this->selectedParent) {
                $categories = [$this->selectedParent];

                if ($this->selectedCategory) {
                    $categories[] = $this->selectedCategory;
                }

                $product->categories()->sync($categories);
            }

            /**
             * 🔹 Ingredients (delete + recreate to keep clean)
             */
            if ($this->ingredients && count($this->ingredients)) {
                $product->ingredients()->delete();

                foreach ($this->ingredients as $ingredient) {
                    $product->ingredients()->create([
                        'name'       => $ingredient['ingredient'],
                        'percentage' => $ingredient['percentage'] ?? null,
                        'benefit'    => $ingredient['benefit'] ?? null,
                    ]);
                }
            }

            /**
             * 🔹 Variants (delete old + recreate with values)
             */
            if ($this->variants && count($this->variants)) {
                $product->variants()->delete();

                foreach ($this->variants as $variantData) {
                    $variant = $product->variants()->create([
                        'sku'    => $variantData['sku'],
                        'price'  => $variantData['price'],
                        'stock'  => $variantData['stock'] ?? 0,
                        'cost'   => $variantData['cost'] ?? 0,
                        'image'  => $variantData['image'] ?? null,
                        'public_id' => $variantData['public_id'] ?? null,
                        'active' => $variantData['active'] ?? true,
                    ]);

                    if (!empty($variantData['value_ids'])) {
                        foreach ($variantData['value_ids'] as $valueId) {
                            $variant->values()->create([
                                'product_option_value_id' => $valueId,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            session()->flash('success', $this->productId ? 'Product updated!' : 'Product created!');
            $this->resetForm();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product save failed: ' . $e->getMessage());
            session()->flash('error', 'Something went wrong while saving product.');
        }
    }


    protected function resetForm()
    {
        // reset only form fields (keep categories/brands/tags loaded)
        $this->reset([
            'name',
            'slug',
            'description',
            'brand',
            'status',
            'schedule_time',
            'thumbnail',
            'gallery',
            'c_price',
            'b_price',
            'discountType',
            'd_value',
            'taxType',
            'vat',
            'f_price',
            'a_profit',
            'sku',
            'track_stock',
            'quantity',
            'variants',
            'selectedParent',
            'subcategories',
            'selectedTags',
            'ins_media',
            'howtouse',
            'ingredients',
            'meta_title',
            'meta_des',
            'meta_keywords'
        ]);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
    public $existingThumbnail;
    public $existingGallery = [];
    public $selectedCategory;
    public $ins_type;
    public $existingInsMedia;
    public function mount($id = null)
    {
        $this->categories = Category::whereNull('parent_id')->where('status', 'active')->get();

        if ($id) {
            $this->productId = $id;
            $product = Product::with([
                'categories',
                'media',
                'tags',
                'prices',
                'instructions',
                'ingredients',
                'variants.values'
            ])->findOrFail($id);

            // fill form fields
            $this->name        = $product->name;
            $this->slug        = $product->slug;
            $this->description = $product->description;
            $this->brand       = $product->brand_id;
            $this->status      = $product->status;
            $this->schedule_time = $product->scheduled_at;
            $this->sku         = $product->sku;
            $this->track_stock = $product->track;
            $this->quantity    = $product->stock;
            $this->meta_title  = $product->meta_title;
            $this->meta_des    = $product->meta_description;
            $this->meta_keywords = $product->meta_keywords;
            //price
            if ($product->prices) {
                // pricing
                $this->c_price = $product->prices->cost_price ?? 0;
                $this->b_price = $product->prices->base_price ?? 0;
                $this->discountType = $product->prices->discount_type ?? 'none'; // none|percent|fixed
                $this->d_value = $product->prices->discount_value ?? 0;
                $this->taxType = $product->prices->tax_class ?? 'tax_free'; // tax_free|taxable|digital
                $this->vat = $product->prices->vat_percent ?? 0;
                $this->f_price = $product->prices->final_price ?? 0;
                $this->a_profit = $product->prices->assuming_profit ?? 0;
            }
            //media
            if ($product->media) {
                $this->existingThumbnail = $product->media()->where('is_thumbnail', true)->first();
                $this->existingGallery   = $product->media()->where('is_thumbnail', false)->get();
            }

            // tags
            $this->selectedTags = $product->tags->pluck('id')->toArray();

            if ($product->categories->count()) {
                // Grab parent and child separately
                $parent = $product->categories->firstWhere('parent_id', null);   // parent category
                $child  = $product->categories->firstWhere('parent_id', '!=', null); // child category

                if ($parent) {
                    $this->selectedParent = $parent->id;
                    // Load children so radios are visible
                    $this->subcategories = Category::where('parent_id', $parent->id)->get();
                }

                if ($child) {
                    $this->selectedCategory = $child->id;
                }
            }



            // instructions
            if ($product->instructions) {
                $this->howtouse = $product->instructions->content ?? '';
                $this->ins_url = $product->url ?? '';
                $this->existingInsMedia = $product->instructions;
            }
            if ($product->variants) {
                $this->dispatch('updatevar', $product->id);
            }
            // ingredients
            $this->ingredients = $product->ingredients->map(function ($ing) {
                return [
                    'ingredient' => $ing->name,
                    'percentage' => $ing->percentage,
                    'benefit'    => $ing->benefit,
                ];
            })->toArray();
            //         $this->dispatch('updateingrediants', ingredients: $this->ingredients)
            //  ->to('dashboard.product-tabs.ingrediant-tab'); // 👈 child component name



            // variants
            $this->variants = $product->variants->map(function ($var) {
                return [
                    'id'        => $var->id,
                    'sku'       => $var->sku,
                    'price'     => $var->price,
                    'stock'     => $var->stock,
                    'cost'      => $var->cost,
                    'image'     => $var->image, // URL string (important!)
                    'public_id' => $var->public_id,
                    'active'    => (bool)$var->active,
                    'value_ids' => $var->values->pluck('product_option_value_id')->toArray(),
                ];
            })->toArray();
        }
    }
    //     public function booted()
    // {
    //     $this->dispatch('updateingrediants', ingredients: $this->ingredients)
    //          ->to('dashboard.product-tabs.ingrediant-tab');
    // }

    public function removeTempInsMedia()
    {
        $this->ins_media = null;
    }

    // Delete existing file (DB + Cloudinary/local)
    public function deleteInsMedia()
    {
        if ($this->existingInsMedia) {

            if ($this->existingInsMedia->file_path) {
                try {
                    $cloudinary = app('cloudinary.account.two');
                    $cloudinary->uploadApi()->destroy($this->existingInsMedia->file_path); // ✅ works now

                    $this->existingInsMedia->file_path = null;
                    $this->existingInsMedia->url = null;
                   $this->existingInsMedia->save();
                } catch (ApiError $e) {
                    Log::error("Cloudinary delete failed: " . $e->getMessage());
                    session()->flash('error', 'Internal server error. Please try later');
                }

                // $this->existingInsMedia->delete();
                $this->existingInsMedia = null;
            }
        }
    }
    public function removeTempThumbnail()
    {
        $this->thumbnail = null;
    }

    // Remove temporary gallery image by index
    public function removeTempGallery($index)
    {
        unset($this->gallery[$index]);
        $this->gallery = array_values($this->gallery); // reindex
    }
    public function deleteMedia($mediaId)
{
    $media = ProductMedia::find($mediaId);

    if (!$media) {
        session()->flash('error', 'Media not found.');
        return;
    }

    // if you stored `public_id` in file_path column
    $publicId = $media->public_id ?? $media->file_path;

    if ($publicId) {
        try {
            $cloudinary = app('cloudinary.account.two');
            $cloudinary->uploadApi()->destroy($publicId);

            $media->delete();
            session()->flash('success', 'Media deleted successfully.');
        } catch (ApiError $e) {
            Log::error("Cloudinary delete failed: " . $e->getMessage());
            session()->flash('error', 'Internal server error. Please try later');
        }
    }

    // Refresh lists
    $this->existingThumbnail = $this->product->media()->where('is_thumbnail', true)->first();
    $this->existingGallery   = $this->product->media()->where('is_thumbnail', false)->get();

    // ✅ Livewire refresh (v3)
    $this->dispatch('refresh');
}
    public function child()
    {
        $this->subcategories = Category::where('parent_id', $this->selectedParent)->where('status', 'active')->get();
    }

    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
        // dd($this->ingredients);
    }

    public function setVariants($variants)
    {
        $this->variants = $variants;
        // dd($this->variants);
    }

    public function render()
    {
        return view('livewire.dashboard.add-product-component', [
            'categories' => $this->categories,
            'brands'     => Brand::where('status', 'active')->get(),
            'tags'       => Tag::all(),
        ])->extends('layouts.admin')->section('admin-content');
    }

    // pricing logic 
    public function updated()
    {
        $this->calculateFinalPrice();
    }

    public function calculateFinalPrice()
    {
        $basePrice = floatval($this->b_price);
        $cost = floatval($this->c_price);

        // Apply Discount
        if ($this->discountType === 'percent' && $this->d_value > 0) {
            $basePrice -= ($basePrice * ($this->d_value / 100));
        } elseif ($this->discountType === 'fixed' && $this->d_value > 0) {
            $basePrice -= $this->d_value;
        }

        // Never go below 0
        $basePrice = max(0, $basePrice);

        // Apply VAT (only if taxable)
        if ($this->taxType === 'taxable' && $this->vat > 0) {
            $basePrice += ($basePrice * ($this->vat / 100));
        }

        // Set final price & profit
        $this->f_price = round($basePrice, 2);
        $this->a_profit = round($this->f_price - $cost, 2);
    }
}
