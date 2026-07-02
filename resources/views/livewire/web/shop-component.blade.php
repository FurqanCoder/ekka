<div>
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Shop</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="ec-breadcrumb-item active">Shop</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <div>
    <!-- Shop page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <!-- Right: products -->
                <div class="ec-shop-rightside col-lg-9 order-lg-last col-md-12 order-md-first margin-b-30">
                    <!-- Shop Top -->
                    <div class="ec-pro-list-top d-flex mb-3">
                        <div class="col-md-6 ec-grid-list">
                            {{-- optional grid/list toggle --}}
                        </div>

                        <div class="col-md-6 ec-sort-select d-flex justify-content-end align-items-center">
                            <span class="sort-by mr-2">Sort by</span>
                            <div class="ec-select-inner">
                                <select wire:model="sort" class="form-control">
                                    <option value="">Position</option>
                                    <option value="name_asc">Name, A to Z</option>
                                    <option value="name_desc">Name, Z to A</option>
                                    <option value="price_asc">Price, low to high</option>
                                    <option value="price_desc">Price, high to low</option>
                                    <option value="latest">Latest</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="shop-pro-content">
                        <div class="shop-pro-inner">
                            <div class="row">
                                @forelse ($products as $product)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <x-product-card :product="$product" />
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-info">No products found for these filters.</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Pagination (Livewire compatible) -->
                        <div class="ec-pro-pagination mt-3">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>

                <!-- Left: sidebar -->
                <div class="ec-shop-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>Filter Products By</h1>
                        </div>

                        <div class="ec-sidebar-wrap">
                            <!-- Search -->
                            <div class="ec-sidebar-block mb-3">
                                <input type="search" wire:model.debounce.400ms="search" class="form-control" placeholder="Search products...">
                            </div>

                            <!-- Category -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title"><h3>Category</h3></div>
                                <div class="ec-sb-block-content">
                                    <ul class="list-unstyled mb-0">
                                        @foreach($categories as $cat)
<label>
    <input type="checkbox" wire:model.defer="selectedCategories" value="{{ $cat->id }}">
    {{ $cat->name }}
</label>
@if($cat->children->isNotEmpty())
    @foreach($cat->children as $child)
    <label class="ml-3">
        <input type="checkbox" wire:model.defer="selectedCategories" value="{{ $child->id }}">
        {{ $child->name }}
    </label>
    @endforeach
@endif
@endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Sizes -->
                            <!-- Sizes -->
@foreach($sizes as $size)
<label>
    <input type="checkbox" wire:model.defer="selectedSizes" value="{{ $size->value }}">
    {{ $size->value }}
</label>
@endforeach

                            <!-- Material -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title"><h3>Material</h3></div>
                                <div class="ec-sb-block-content">
                                    @foreach($material as $m)
<label>
    <input type="checkbox" wire:model.defer="selectedMaterial" value="{{ $m->value }}">
    {{ $m->value }}
</label>
@endforeach
                                </div>
                            </div>

                            <!-- Colors (checkbox + swatch) -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title"><h3>Color</h3></div>
                                <div class="ec-sb-block-content d-flex flex-wrap">
                                   <!-- Colors -->
@foreach($colors as $color)
<label>
    <input type="checkbox" wire:model.defer="selectedColors" value="{{ $color->value }}">
    {{ $color->value }}
</label>
@endforeach
                                </div>
                            </div>

                            <!-- Tags (optional) -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title"><h3>Tags</h3></div>
                                <div class="ec-sb-block-content">
                                    @foreach($tags as $tag)
                                        <label class="d-flex align-items-center small">
                                            <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}">
                                            <span class="ml-2">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title"><h3>Price</h3></div>
                                <div class="ec-sb-block-content">
                                    <input type="number" wire:model.defer="minPrice" placeholder="Min" class="form-control mb-1">
                                    <input type="number" wire:model.defer="maxPrice" placeholder="Max" class="form-control mb-1">

                                    {{-- @if($requireApplyForPrice) --}}
                                        <div class="d-flex">
                                            <button wire:click="applyFilters">Apply Filters</button>
<button wire:click="resetFilters">Reset</button>
                                        </div>
                                    {{-- @else
                                        <div class="d-flex">
                                            <button type="button" wire:click="resetFilters" class="btn btn-link btn-sm">Reset</button>
                                        </div>
                                    @endif --}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Left -->
            </div>
        </div>
    </section>
    <!-- End Shop page -->
</div>

{{-- Optional JS: emit price range from a slider (if you use noUiSlider or any slider)
     Example usage (vanilla): Livewire.emit('applyPriceRange', minValue, maxValue)
--}}

</div>
