@extends('layouts.web')

@section('web-content')
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
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Shop</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="ec-shop-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>Filter Products By</h1>
                        </div>

                        @php
                            // Ensure inputs are treated as arrays for persistence checks
                            // Using 'categories' key from request which Laravel parses as array if [] is used in input name
                            $selectedCategories = (array) request('categories', []);
                            $selectedSizes = (array) request('sizes', []);
                            $selectedMaterial = (array) request('material', []);
                            $selectedColors = (array) request('colors', []);
                            $selectedSort = (array) request('sort', []);
                            // Map to strings for comparison
                            $selectedCategories = array_map('strval', $selectedCategories);
                        @endphp
                        <div class="ec-sidebar-wrap">
                            <div class="ec-sidebar-block mb-3">
                                <input type="search" id="productSearch" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search products...">
                            </div>
                            <!-- Category -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3>Category</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($categories as $cat)
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    {{-- FIX: Added [] back to name so PHP sees it as an array --}}
                                                    <input type="checkbox" class="filter" name="categories[]"
                                                        value="{{ $cat->id }}"
                                                        {{ in_array((string) $cat->id, $selectedCategories) ? 'checked' : '' }}>
                                                    <a>{{ $cat->name }}</a>
                                                    <span class="checked"></span>
                                                </div>
                                            </li>

                                            @foreach ($cat->children as $child)
                                                <li>
                                                    <div class="ec-sidebar-block-item" style="margin-left:15px;">
                                                        {{-- FIX: Added [] back to name --}}
                                                        <input type="checkbox" class="filter" name="categories[]"
                                                            value="{{ $child->id }}"
                                                            {{ in_array((string) $child->id, $selectedCategories) ? 'checked' : '' }}>
                                                        <a>{{ $child->name }}</a> <span class="checked"></span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>

                            </div>


                            <!-- Size -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Size</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        @foreach ($sizes as $size)
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    {{-- FIX: Added [] back to name --}}
                                                    <input type="checkbox" class="filter" name="sizes[]"
                                                        value="{{ $size->value }}"
                                                        {{ in_array($size->value, $selectedSizes) ? 'checked' : '' }}>
                                                    <a> {{ $size->value }}</a><span class="checked"></span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>



                            <!-- Material -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Material</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        @foreach ($material as $m)
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    {{-- FIX: Added [] back to name --}}
                                                    <input type="checkbox" class="filter" name="material[]"
                                                        value="{{ $m->value }}"
                                                        {{ in_array($m->value, $selectedMaterial) ? 'checked' : '' }}>
                                                    <a>{{ $m->value }}</a> <span class="checked"></span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            {{-- color --}}
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Color</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        @foreach ($colors as $color)
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    {{-- FIX: Added [] back to name --}}
                                                    <input type="checkbox" class="filter" name="colors[]"
                                                        value="{{ $color->value }}"
                                                        {{ in_array($color->value, $selectedColors) ? 'checked' : '' }}>
                                                    <a>{{ $color->value }}</a> <span class="checked"></span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Price</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <input type="number" id="minPrice" name="minPrice" placeholder="Min"
                                        value="{{ request('minPrice') }}" class="form-control mb-1">
                                    <input type="number" id="maxPrice" name="maxPrice" placeholder="Max"
                                        value="{{ request('maxPrice') }}" class="form-control mb-1">
                                    <button id="applyFilters" class="btn btn-sm btn-primary">Apply</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Products -->

                <div class="ec-shop-rightside col-lg-9 order-lg-last col-md-12 order-md-first margin-b-30">
                    <!-- Shop Top -->
                    <div class="ec-pro-list-top d-flex mb-3">
                        <div class="col-md-6 ec-grid-list">
                            {{-- optional grid/list toggle --}}
                        </div>

                        <div class="col-md-6 ec-sort-select d-flex justify-content-end align-items-center">
                            <span class="sort-by mr-2">Sort by</span>
                            <div class="ec-select-inner">
                                {{-- Added ID, Name, and persistence via Blade --}}
                                <select class="form-control" id="productSort" name="sort">
                                    <option value="" {{ $selectedSort == '' ? 'selected' : '' }}>Position</option>
                                    <option value="name_asc" {{ $selectedSort == 'name_asc' ? 'selected' : '' }}>Name, A to
                                        Z</option>
                                    <option value="name_desc" {{ $selectedSort == 'name_desc' ? 'selected' : '' }}>Name, Z
                                        to A</option>
                                    <option value="price_asc" {{ $selectedSort == 'price_asc' ? 'selected' : '' }}>Price,
                                        low to high</option>
                                    <option value="price_desc" {{ $selectedSort == 'price_desc' ? 'selected' : '' }}>Price,
                                        high to low</option>
                                    <option value="latest" {{ $selectedSort == 'latest' ? 'selected' : '' }}>Latest
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="product-list">
                        @include('partials.web.products')
                    </div>
                </div>

            </div>

        </div>

    </section>
    <script>
        function applyFilters() {
            let params = new URLSearchParams();

            // 1. Collect all checked values (filters)
            document.querySelectorAll('.filter').forEach(el => {
                if (el.checked) {
                    // This appends "categories[]=1", "categories[]=2"
                    // URLSearchParams handles this correctly, and PHP decodes it as an array
                    params.append(el.name, el.value);
                }
            });

            // 2. Add price range
            let minPrice = document.getElementById('minPrice').value;
            let maxPrice = document.getElementById('maxPrice').value;
            if (minPrice) params.append('minPrice', minPrice);
            if (maxPrice) params.append('maxPrice', maxPrice);
            let searchTerm = document.getElementById('productSearch').value;
if (searchTerm) params.append('search', searchTerm);
  //  This ensures that whenever any filter is changed, or the "Apply" button is clicked, the current search term is automatically included in the AJAX request parameters.
            // 3. Add sorting option (NEW)
            const productSort = document.getElementById('productSort');
            if (productSort && productSort.value) {
                params.append('sort', productSort.value);
            }

            // Preserve pagination if needed
            const currentParams = new URLSearchParams(window.location.search);
            if (currentParams.has('page')) params.set('page', currentParams.get('page'));
            // NOTE: We no longer need to check for 'sort' in currentParams here since we read it from the DOM element

            let url = `{{ route('web.filter') }}?${params.toString()}`;

            // Update URL
            history.pushState(null, '', url);

            // Show loading
            const productList = document.getElementById('product-list');
            productList.innerHTML = '<div style="text-align:center; padding: 50px;">Loading products...</div>';

            // AJAX Load Products
            fetch(url, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(res => res.text())
                .then(html => {
                    console.log("Products Loaded"); // Debug check
                    productList.innerHTML = html;

                    // 🔥 CRITICAL FIX: Manually show elements that have animation attributes
                    // This fixes the issue where products are loaded but invisible (opacity: 0)
                    productList.querySelectorAll('[data-animation]').forEach(el => {
                        el.style.opacity = '1';
                        el.style.visibility = 'visible';
                        el.style.animationName = 'none'; // Prevents animation conflicts
                    });

                    // Optional: Dispatch Livewire event if you use Livewire components inside the loop
                    if (window.Livewire) {
                        window.Livewire.dispatch('refresh');
                    }
                })
                .catch(error => {
                    console.error('Filtering failed:', error);
                    productList.innerHTML = '<p class="text-danger">Failed to load products. Please try again.</p>';
                });


        }

        // Attach listeners
        document.querySelectorAll('.filter').forEach(el => {
            el.addEventListener('change', applyFilters);
        });

        document.getElementById('applyFilters').addEventListener('click', applyFilters);

        // Attach listener for the new sorting dropdown
        document.getElementById('productSort').addEventListener('change', applyFilters);
        document.getElementById('productSearch').addEventListener('change', applyFilters);
  //  This listener ensures that if the user types a query and then clicks out of the search box (or presses Enter), the filters are applied instantly, even if they haven't touched the "Apply" button or other checkboxes.
    </script>
@endsection
