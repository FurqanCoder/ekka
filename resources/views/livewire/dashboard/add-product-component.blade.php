<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Add Product</h4>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item d-flex align-items-center">
                                        <a class="text-muted text-decoration-none d-flex" href="index.html">
                                            <iconify-icon icon="solar:home-2-line-duotone"
                                                class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                            Add Product
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start Basic Area Chart -->
            {{-- resources/views/dashboard/product-create.blade.php --}}
            <div class="container-fluid py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Add Product</h3>
                    <div>
                        <button id="saveButton" wire:click="save" class="btn btn-primary">Save Product</button>
                        <a href="#" class="btn bg-danger-subtle text-danger ms-2">Cancel</a>
                    </div>
                </div>

                {{-- success / error flash --}}
                @if (session()->has('success'))
                    <div class="alert alert-success" id="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger" id="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- <pre>{{ var_export($howtouse, true) }}</pre> --}}

                <div class="card">
                    <div class="card-body">

                        {{-- Nav tabs --}}
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'general' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('general')">
                                    General
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'media' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('media')">
                                    Media
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'pricing' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('pricing')">
                                    Pricing
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'inventory' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('inventory')">
                                    Inventory
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'variants' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('variants')">
                                    Variants
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'associations' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('associations')">
                                    Categories & Tags
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'ins' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('ins')">
                                    How to Use
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'ingredients' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('ingredients')">
                                    Ingredients
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'seo' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('seo')">
                                    SEO
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeTab === 'settings' ? 'active' : '' }}" href="#"
                                    wire:click.prevent="setTab('settings')">
                                    Settings
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <form wire:submit.prevent="save">
                            <div class="tab-content pt-4">

                                {{-- GENERAL --}}
                                <div class="tab-pane fade {{ $activeTab === 'general' ? 'show active' : '' }}"
                                    id="tab-general" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-lg-8">
                                            <div class="mb-3">
                                                <label class="form-label">Product Name <span
                                                        class="text-danger">*</span></label>
                                                <input id="productName" wire:model.defer="name" type="text"
                                                    class="form-control" placeholder="e.g., Wireless Headphones" />
                                                <small class="text-muted d-block mt-1">Make it unique and
                                                    descriptive.</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Slug</label>
                                                <input id="productSlug" type="text" wire:model.defer="slug"
                                                    class="form-control" placeholder="auto-generated if left blank" />
                                            </div>

                                            <div class="mb-3" wire:ignore>
                                                <label class="form-label">Description</label>
                                                <div x-data x-init="const quill = new Quill($refs.editor, { theme: 'snow' });
                                                
                                                // Load initial Livewire value
                                                quill.root.innerHTML = @js($description);
                                                
                                                // Watch for changes from Livewire side
                                                $watch('description', value => {
                                                    if (value !== quill.root.innerHTML) {
                                                        quill.root.innerHTML = value || '';
                                                    }
                                                });
                                                
                                                // Push changes to Livewire when editing
                                                quill.on('text-change', function() {
                                                    @this.set('description', quill.root.innerHTML);
                                                });">
                                                    <div x-ref="editor" style="min-height: 150px;"></div>
                                                </div>

                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                <small class="text-muted d-block mt-1">
                                                    Set a detailed description for better visibility.
                                                </small>
                                            </div>




                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Brand</label>
                                                <select id="brandSelect" wire:model.defer="brand"
                                                    class="form-select">
                                                    <option value="">— Select Brand —</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select id="statusSelect" wire:model.defer="status"
                                                    class="form-select">
                                                    <option value="live">Live</option>
                                                    <option value="draft">Draft</option>
                                                    <option value="scheduled">Scheduled</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>

                                            <div class="mb-3" id="scheduleContainer" style="display:none;">
                                                <label class="form-label">Schedule Date/Time</label>
                                                <input id="scheduledAt" wire:model.defer="schedule_time"
                                                    type="datetime-local" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- MEDIA --}}
                                <div class="tab-pane fade {{ $activeTab === 'media' ? 'show active' : '' }}"
                                    id="tab-media" role="tabpanel">
                                    <div class="row g-4">
                                        {{-- Thumbnail --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Thumbnail</label>
                                            <input type="file" wire:model="thumbnail" accept="image/*"
                                                class="form-control" />
                                            @error('thumbnail')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                            <div class="mt-2">
                                                {{-- Existing thumbnail --}}
                                                @if ($existingThumbnail)
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ $existingThumbnail->file_path }}" alt="thumb"
                                                            class="rounded border"
                                                            style="max-width:80px; min-height:75px">
                                                        <button type="button"
                                                            wire:click="deleteMedia({{ $existingThumbnail->id }})"
                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                                            ✕
                                                        </button>
                                                    </div>
                                                @endif

                                                {{-- New uploaded preview --}}
                                                @if ($thumbnail)
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ $thumbnail->temporaryUrl() }}" alt="thumb"
                                                            class="rounded border"
                                                            style="max-width:80px; min-height:75px">
                                                        <button type="button" wire:click="removeTempThumbnail"
                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                                            ✕
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-2">Only *.png, *.jpg and *.jpeg files
                                                are accepted.</small>
                                        </div>

                                        {{-- Gallery --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Gallery</label>
                                            <input type="file" wire:model="gallery" multiple accept="image/*"
                                                class="form-control" />
                                            @error('gallery.*')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                            <div class="d-flex gap-2 flex-wrap mt-2">
                                                {{-- Existing gallery images --}}
                                                @foreach ($existingGallery as $media)
                                                    <div class="position-relative">
                                                        <img src="{{ $media->file_path }}" class="rounded border"
                                                            style="max-width:80px; min-height:75px">
                                                        <button type="button"
                                                            wire:click="deleteMedia({{ $media->id }})"
                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                                            ✕
                                                        </button>
                                                    </div>
                                                @endforeach

                                                {{-- New uploaded gallery preview --}}
                                                @if ($gallery)
                                                    @foreach ($gallery as $index => $file)
                                                        <div class="position-relative">
                                                            <img src="{{ $file->temporaryUrl() }}"
                                                                class="rounded border"
                                                                style="max-width:80px; min-height:75px">
                                                            <button type="button"
                                                                wire:click="removeTempGallery({{ $index }})"
                                                                class="btn btn-sm btn-danger position-absolute top-0 end-0">
                                                                ✕
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- PRICING --}}
                                <div class="tab-pane fade {{ $activeTab === 'pricing' ? 'show active' : '' }}"
                                    id="tab-pricing" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Cost Price (Your cost) <span
                                                        class="text-danger">*</span></label>
                                                <input id="costPrice" wire:model.live="c_price" type="number"
                                                    step="0.01" class="form-control" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Base Price (MRP) <span
                                                        class="text-danger">*</span></label>
                                                <input id="basePrice" wire:model.live="b_price" type="number"
                                                    step="0.01" class="form-control" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Discount</label>
                                                <div class="d-flex gap-2">
                                                    <select id="discountType" wire:model.live="discountType"
                                                        class="form-select w-auto">
                                                        <option value="none">No Discount</option>
                                                        <option value="percent">Percent %</option>
                                                        <option value="fixed">Fixed</option>
                                                    </select>
                                                    <input id="discountValue" wire:model.live="d_value"
                                                        type="number" step="0.01" class="form-control"
                                                        placeholder="Value" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tax Class</label>
                                                <select id="taxClass" wire:model.live="taxType" class="form-select">
                                                    <option value="tax_free">Tax Free</option>
                                                    <option value="taxable">Taxable Goods</option>
                                                    <option value="digital">Downloadable Products</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">VAT (%)</label>
                                                <input id="vatPercent" wire:model.live="vat" type="number"
                                                    step="0.01" class="form-control" />
                                                <small class="text-muted">Applied on discounted price if
                                                    taxable.</small>
                                            </div>

                                            <div class="p-3 bg-light rounded">
                                                <div class="d-flex justify-content-between">
                                                    <span>Effective Selling Price (Final Price)</span>
                                                    <span class="fw-bold text-success">
                                                        {{ number_format($f_price, 2) }}
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between mt-1">
                                                    <span>Profit / Unit</span>
                                                    <span class="fw-bold text-primary">
                                                        {{ number_format($a_profit, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- INVENTORY --}}
                                <div class="tab-pane fade {{ $activeTab === 'inventory' ? 'show active' : '' }}"
                                    id="tab-inventory" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label">SKU</label>
                                            <input id="sku" wire:model.defer="sku" type="text"
                                                class="form-control" />
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <label class="form-label">Barcode</label>
                                            <input id="barcode" type="text" class="form-control" />
                                        </div> --}}

                                        <div class="col-md-6">
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" wire:model.defer="track_stock"
                                                    type="checkbox" id="trackStock" checked>
                                                <label class="form-check-label" for="trackStock">Track Stock</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Stock Quantity</label>
                                            <input id="stockQty" wire:model.defer="quantity" type="number"
                                                class="form-control" value="0" />
                                        </div>
                                    </div>
                                </div>

                                {{-- VARIANTS --}}
                                <div class="tab-pane fade {{ $activeTab === 'variants' ? 'show active' : '' }}"
                                    id="tab-variants" role="tabpanel">

                                    <livewire:dashboard.product-tabs.variants-tab :productId="$productId" :variants="$variants" />


                                </div>

                                {{-- CATEGORIES & TAGS --}}
                                <div class="tab-pane fade {{ $activeTab === 'associations' ? 'show active' : '' }}"
                                    id="tab-associations" role="tabpanel">
                                    <div class="row g-4">
                                        {{-- Categories --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Categories</label>
                                            {{-- Parent categories --}}
                                            <div class="border rounded p-2" style="max-height:240px; overflow:auto;">
                                                @foreach ($categories as $category)
                                                    <div wire:key="parent-{{ $category->id }}">
                                                        <input type="radio" name="parentCategory"
                                                            value="{{ $category->id }}" wire:click="child"
                                                            wire:model="selectedParent">
                                                        {{ $category->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted d-block mt-1">Select a parent category.</small>

                                            {{-- Subcategories (shown only if parent selected) --}}
                                            @if ($subcategories && count($subcategories))
                                                <div class="mt-3">
                                                    <label class="form-label">Subcategories</label>
                                                    <div class="border rounded p-2"
                                                        style="max-height:240px; overflow:auto;">
                                                        @foreach ($subcategories as $subcategory)
                                                            <div wire:key="child-{{ $subcategory->id }}">
                                                                <input type="radio" name="childCategory"
                                                                    value="{{ $subcategory->id }}"
                                                                    wire:model="selectedCategory">
                                                                {{ $subcategory->name }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <small class="text-muted d-block mt-1">Select only one child
                                                        category.</small>
                                                </div>
                                            @endif
                                        </div>



                                        {{-- Tags --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Tags</label>
                                            <div class="border rounded p-2" style="max-height:240px; overflow:auto;">
                                                @foreach ($tags as $tag)
                                                    <div>
                                                        <input type="checkbox" value="{{ $tag->id }}"
                                                            wire:model.defer="selectedTags">
                                                        {{ $tag->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted d-block mt-1">Use tags to improve search &
                                                collections.</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- How to Use -->
                                <div class="tab-pane fade {{ $activeTab === 'ins' ? 'show active' : '' }}"
                                    id="ins">
                                    <div class="mb-3" wire:ignore>
                                        <label class="form-label">How to Use</label>
                                        <div wire:ignore x-data x-init="const quill = new Quill($refs.instruction, { theme: 'snow' });
                                        // Load initial Livewire value
                                        quill.root.innerHTML = @js($howtouse);
                                        
                                        // Watch for changes from Livewire side
                                        $watch('description', value => {
                                            if (value !== quill.root.innerHTML) {
                                                quill.root.innerHTML = value || '';
                                            }
                                        });
                                        quill.on('text-change', function() {
                                            @this.set('howtouse', quill.root.innerHTML);
                                        });">
                                            <div x-ref="instruction" style="min-height: 50px;"></div>
                                        </div>

                                        @error('howtouse')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>




                                    <div class="mb-3">
                                        <label class="form-label">Upload Image / Video</label>
                                        <input wire:model="ins_media" type="file" accept="image/*,video/*"
                                            class="form-control" />
                                        @error('ins_media')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                         <label class="form-label mt-2">Upload Online Media(Url)</label>
                                        <input wire:model="ins_url" type="" 
                                            class="form-control" placeholder="link paste here"/>

                                        <div class="mt-3">
                                            {{-- Show existing media (from DB) --}}
                                            @if ($existingInsMedia)
                                                <div class="position-relative d-inline-block">
                                                    @if (str_contains($existingInsMedia->type, 'image'))
                                                        <img src="{{ $existingInsMedia->url }}" alt="preview"
                                                            class="rounded border"
                                                            style="max-width:85px; max-height:70px;">
                                                    @elseif (str_contains($existingInsMedia->type, 'video'))
                                                        <video controls class="rounded border"
                                                            style="max-width:300px; max-height:200px;">
                                                            <source src="{{ $existingInsMedia->url }}"
                                                                type="{{ $existingInsMedia->type }}">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                    <button type="button" wire:click="deleteInsMedia"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0">✕</button>
                                                </div>
                                            @endif

                                            {{-- Show temporary uploaded media --}}
                                            @if ($ins_media && !$existingInsMedia)
                                                <div class="position-relative d-inline-block">
                                                    @if (str_contains($ins_media->getMimeType(), 'image'))
                                                        <img src="{{ $ins_media->temporaryUrl() }}" alt="preview"
                                                            class="rounded border"
                                                            style="max-width:85px; max-height:70px;">
                                                    @elseif (str_contains($ins_media->getMimeType(), 'video'))
                                                        <video controls class="rounded border"
                                                            style="max-width:300px; max-height:200px;">
                                                            <source src="{{ $ins_media->temporaryUrl() }}"
                                                                type="{{ $ins_media->getMimeType() }}">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                    <button type="button" wire:click="removeTempInsMedia"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0">✕</button>
                                                </div>
                                            @endif
                                        </div>

                                        <small class="text-muted d-block mt-2">Only *jpg, *png, *mp4 files are
                                            accepted.</small>
                                    </div>


                                </div>

                                <!-- Ingredients -->
                                <div class="tab-pane fade {{ $activeTab === 'ingredients' ? 'show active' : '' }}"
                                    id="ingredients">
                                    <livewire:dashboard.product-tabs.ingrediant-tab :ingredients="$ingredients" />

                                </div>

                                {{-- SEO --}}
                                <div class="tab-pane fade {{ $activeTab === 'seo' ? 'show active' : '' }}"
                                    id="tab-seo" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-lg-8">
                                            <div class="mb-3">
                                                <label class="form-label">Meta Title</label>
                                                <input id="metaTitle" type="text" wire:model.defer="meta_title"
                                                    class="form-control" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Meta Description</label>
                                                <textarea id="metaDescription" rows="3" wire:model.defer="meta_des" class="form-control"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Meta Keywords</label>
                                                <input id="metaKeywords"
                                                    type="text"wire:model.defer="meta_keywords"
                                                    class="form-control" placeholder="keyword1, keyword2" />
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="p-3 bg-light rounded">
                                                <div><strong>SEO completeness</strong></div>
                                                <div class="progress mt-2">
                                                    <div id="seoProgress" class="progress-bar" role="progressbar"
                                                        style="width: 0%"></div>
                                                </div>
                                                <small class="text-muted">Fill all fields for best results.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SETTINGS --}}
                                <div class="tab-pane fade {{ $activeTab === 'settings' ? 'show active' : '' }}"
                                    id="tab-settings" role="tabpanel">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Product Template</label>
                                            <select id="templateSelect" class="form-select">
                                                <option value="default">Default Template</option>
                                                <option value="fashion">Fashion</option>
                                                <option value="office">Office Stationary</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="d-flex justify-content-end mt-4">
                            <button id="saveBottomBtn" wire:click="save" class="btn btn-primary">Save
                                Product</button>
                            <a href="#" class="btn bg-danger-subtle text-danger ms-2">Cancel</a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Trix styles & script --}}
            <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
            <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
            {{-- <script>
                document.addEventListener("trix-change", function(event) {
                    @this.set('description', event.target.value);
                });
                document.addEventListener("trix-change", function(event) {
                    @this.set('howtouse ', event.target.value);
                });
            </script> --}}

            <script>
                // Simple frontend logic for the UI (no backend)
                document.addEventListener('DOMContentLoaded', () => {

                    // Schedule field toggle
                    const statusSelect = document.getElementById('statusSelect');
                    const scheduleContainer = document.getElementById('scheduleContainer');
                    statusSelect.addEventListener('change', () => {
                        scheduleContainer.style.display = statusSelect.value === 'scheduled' ? 'block' : 'none';
                    });

                    // Thumbnail preview
                    const thumbnailInput = document.getElementById('thumbnailInput');
                    const thumbnailPreview = document.getElementById('thumbnailPreview');
                    thumbnailInput.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        if (!file) return;
                        const url = URL.createObjectURL(file);
                        thumbnailPreview.src = url;
                        thumbnailPreview.style.display = 'block';
                    });

                    // Gallery preview
                    const galleryInput = document.getElementById('galleryInput');
                    const galleryPreview = document.getElementById('galleryPreview');
                    galleryInput.addEventListener('change', (e) => {
                        galleryPreview.innerHTML = '';
                        Array.from(e.target.files).forEach(file => {
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.style.width = '80px';
                            img.style.height = '80px';
                            img.style.objectFit = 'cover';
                            img.className = 'rounded';
                            galleryPreview.appendChild(img);
                        });
                    });

                    // Pricing calculations
                    const costPrice = document.getElementById('costPrice');
                    const basePrice = document.getElementById('basePrice');
                    const discountType = document.getElementById('discountType');
                    const discountValue = document.getElementById('discountValue');
                    const vatPercent = document.getElementById('vatPercent');
                    const taxClass = document.getElementById('taxClass');
                    const effectivePriceEl = document.getElementById('effectivePrice');
                    const profitEl = document.getElementById('profitPerUnit');

                    function computeEffective() {
                        let price = parseFloat(basePrice.value || 0);
                        const cost = parseFloat(costPrice.value || 0);
                        const dtype = discountType.value;
                        const dvalue = parseFloat(discountValue.value || 0);

                        if (dtype === 'percent') {
                            price = price * Math.max(0, (100 - dvalue)) / 100;
                        } else if (dtype === 'fixed') {
                            price = Math.max(0, price - dvalue);
                        }

                        if (taxClass.value !== 'tax_free') {
                            const vat = parseFloat(vatPercent.value || 0);
                            if (vat > 0) price = price * (1 + vat / 100);
                        }

                        effectivePriceEl.value = price.toFixed(2);
                        profitEl.value = Math.max(0, price - cost).toFixed(2);
                    }

                    [costPrice, basePrice, discountType, discountValue, vatPercent, taxClass].forEach(el => {
                        el.addEventListener('input', computeEffective);
                        el.addEventListener('change', computeEffective);
                    });
                    computeEffective();

                    // Variants: dynamic options & generator (client-side)
                    const hasVariants = document.getElementById('hasVariants');
                    const variantsArea = document.getElementById('variantsArea');
                    const addOptionBtn = document.getElementById('addOptionBtn');
                    const optionsWrapper = document.getElementById('optionsWrapper');
                    const generateVariantsBtn = document.getElementById('generateVariantsBtn');
                    const variantsTableWrapper = document.getElementById('variantsTableWrapper');
                    const variantsTableBody = document.getElementById('variantsTableBody');

                    function createOptionBlock(index, name = '', values = '') {
                        const col = document.createElement('div');
                        col.className = 'col-md-4';
                        col.innerHTML = `
        <label class="form-label">Option Name</label>
        <input type="text" class="form-control mb-2 opt-name" data-idx="${index}" placeholder="e.g., Size" value="${name}">
        <label class="form-label">Values (comma separated)</label>
        <input type="text" class="form-control opt-values" data-idx="${index}" placeholder="S, M, L" value="${values}">
        <div class="mt-2 d-flex gap-2">
          <button class="btn btn-sm bg-danger-subtle text-danger remove-option">Remove</button>
        </div>
      `;
                        return col;
                    }

                    let optionCount = 0;

                    function addOption(name = '', values = '') {
                        if (optionCount >= 3) return;
                        const block = createOptionBlock(optionCount, name, values);
                        optionsWrapper.appendChild(block);
                        optionCount++;
                        updateOptionRemoveButtons();
                    }

                    function updateOptionRemoveButtons() {
                        optionsWrapper.querySelectorAll('.remove-option').forEach(btn => {
                            btn.onclick = (e) => {
                                e.target.closest('.col-md-4').remove();
                                optionCount--;
                            };
                        });
                    }

                    hasVariants.addEventListener('change', () => {
                        variantsArea.style.display = hasVariants.checked ? 'block' : 'none';
                    });

                    addOptionBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        addOption();
                    });

                    // start with one option block when variants toggled on
                    hasVariants.addEventListener('click', () => {
                        if (hasVariants.checked && optionsWrapper.children.length === 0) addOption('Size',
                            'S, M, L');
                    });

                    // Variant generator: reads option blocks, computes product
                    generateVariantsBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        // gather options
                        const optNames = [];
                        const optValues = [];
                        optionsWrapper.querySelectorAll('.col-md-4').forEach(col => {
                            const name = (col.querySelector('.opt-name').value || '').trim();
                            const vals = (col.querySelector('.opt-values').value || '').split(',').map(v =>
                                v.trim()).filter(Boolean);
                            if (name && vals.length) {
                                optNames.push(name);
                                optValues.push(vals);
                            }
                        });

                        // if no options -> hide table
                        if (optValues.length === 0) {
                            variantsTableWrapper.style.display = 'none';
                            variantsTableBody.innerHTML = '';
                            return;
                        }

                        // compute cartesian product
                        function cartesian(arr) {
                            return arr.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [
                                []
                            ]);
                        }
                        const combos = cartesian(optValues);

                        // build rows
                        variantsTableBody.innerHTML = '';
                        combos.forEach(parts => {
                            const labelParts = parts.map((v, idx) => `${optNames[idx]}:${v}`);
                            const key = labelParts.join(' | ');
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
  <td>${key}</td>
  <td><input type="text" class="form-control variant-sku" /></td>
  <td><input type="number" step="0.01" class="form-control variant-price" /></td>
  <td><input type="number" step="0.01" class="form-control variant-cost" /></td>
  <td><input type="number" class="form-control variant-stock" value="0" /></td>
  <td>
    <input type="color" class="form-control form-control-color variant-color" value="#000000" />
  </td>
  <td>
    <input type="file" class="form-control variant-image" accept="image/*" />
    <div class="mt-1"><img class="img-thumbnail variant-preview" style="max-height:50px;display:none;"></div>
  </td>
  <td class="text-center">
    <input type="checkbox" class="form-check-input variant-active" checked />
  </td>
`;

                            variantsTableBody.appendChild(tr);
                        });
                        variantsTableWrapper.style.display = 'block';
                        // Preview image when file selected
                        variantsTableBody.addEventListener('change', (e) => {
                            if (e.target.classList.contains('variant-image')) {
                                const fileInput = e.target;
                                const preview = fileInput.parentElement.querySelector('.variant-preview');
                                if (fileInput.files && fileInput.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = (ev) => {
                                        preview.src = ev.target.result;
                                        preview.style.display = 'block';
                                    };
                                    reader.readAsDataURL(fileInput.files[0]);
                                }
                            }
                        });

                    });

                    // SEO progress
                    const metaTitle = document.getElementById('metaTitle');
                    const metaDescription = document.getElementById('metaDescription');
                    const metaKeywords = document.getElementById('metaKeywords');
                    const seoProgress = document.getElementById('seoProgress');

                    function updateSEOProgress() {
                        let score = 0;
                        if (metaTitle.value.trim()) score += 33;
                        if (metaDescription.value.trim()) score += 33;
                        if (metaKeywords.value.trim()) score += 34;
                        seoProgress.style.width = score + '%';
                        seoProgress.textContent = score + '%';
                    }
                    [metaTitle, metaDescription, metaKeywords].forEach(el => el.addEventListener('input',
                        updateSEOProgress));
                    updateSEOProgress();

                    // Auto-slugger
                    const productName = document.getElementById('productName');
                    const productSlug = document.getElementById('productSlug');
                    productName.addEventListener('input', () => {
                        if (!productSlug.value) {
                            productSlug.value = productName.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-')
                                .replace(/(^-|-$)/g, '');
                        }
                    });

                    // Trix change -> copy into hidden
                    const trixEditor = document.getElementById('trixDescription');
                    if (trixEditor) {
                        trixEditor.addEventListener('trix-change', () => {
                            document.getElementById('x-description').value = trixEditor.innerHTML;
                        });
                    }

                    // Save button (client-side collect)
                    function collectForm() {
                        const data = {
                            name: productName.value,
                            slug: productSlug.value,
                            description: document.getElementById('x-description').value,
                            brand: document.getElementById('brandSelect').value,
                            status: document.getElementById('statusSelect').value,
                            scheduled_at: document.getElementById('scheduledAt').value,
                            pricing: {
                                cost: parseFloat(costPrice.value || 0),
                                base: parseFloat(basePrice.value || 0),
                                discountType: discountType.value,
                                discountValue: parseFloat(discountValue.value || 0),
                                vat: parseFloat(vatPercent.value || 0),
                                taxClass: taxClass.value,
                            },
                            inventory: {
                                sku: document.getElementById('sku').value,
                                barcode: document.getElementById('barcode').value,
                                stock: parseInt(document.getElementById('stockQty').value || 0),
                                track_stock: document.getElementById('trackStock').checked
                            },
                            seo: {
                                title: metaTitle.value,
                                description: metaDescription.value,
                                keywords: metaKeywords.value
                            }
                        };

                        // collect options
                        data.options = [];
                        optionsWrapper.querySelectorAll('.col-md-4').forEach(col => {
                            data.options.push({
                                name: col.querySelector('.opt-name').value,
                                values: col.querySelector('.opt-values').value.split(',').map(v => v.trim())
                                    .filter(Boolean)
                            });
                        });

                        // collect variants table values
                        data.variants = [];
                        variantsTableBody.querySelectorAll('tr').forEach(tr => {
                            data.variants.push({
                                key: tr.cells[0].textContent.trim(),
                                sku: tr.querySelector('.variant-sku').value,
                                price: parseFloat(tr.querySelector('.variant-price').value || 0),
                                cost_price: parseFloat(tr.querySelector('.variant-cost').value || 0),
                                stock: parseInt(tr.querySelector('.variant-stock').value || 0)
                            });
                        });

                        return data;
                    }

                    function showCollectedPreview() {
                        const payload = collectForm();
                        // for demo we print to console. Replace with actual ajax/livewire call later.
                        console.log('PRODUCT PAYLOAD (frontend only):', payload);
                        alert('Check console: product payload collected (frontend only).');
                    }

                    document.getElementById('saveButton').addEventListener('click', showCollectedPreview);
                    document.getElementById('saveBottomBtn').addEventListener('click', showCollectedPreview);

                    // initialize with 1 option block (hidden until variants on)
                    addOption('Size', 'S, M, L');

                });

                function addIngredientRow() {
                    const table = document.getElementById('ingredientTable');
                    const row = document.createElement('tr');
                    row.innerHTML = `
      <td><input type="text" class="form-control" placeholder="Ingredient name"></td>
      <td><input type="number" class="form-control" placeholder="%"></td>
      <td><input type="text" class="form-control" placeholder="Benefit"></td>
      <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">×</button></td>
    `;
                    table.appendChild(row);
                }

                function removeRow(btn) {
                    btn.closest('tr').remove();
                }
            </script>

            <style>
                /* small visual tweaks */
                .trix-content {
                    min-height: 180px;
                    border: 1px solid #e9ecef;
                    border-radius: .375rem;
                    padding: .5rem;
                }

                .bg-primary-subtle {
                    background-color: rgba(13, 110, 253, 0.06);
                }

                .bg-danger-subtle {
                    background-color: rgba(220, 53, 69, 0.06);
                }
            </style>

            <!-- end Basic Area Chart -->
        </div>
    </div>
</div>
