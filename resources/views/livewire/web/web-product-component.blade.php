<div>
    <style>
        /* Offer Styles */
        .offer-label {
            display: inline-block;
            background: #ff6b6b;
            color: #fff;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .old-price {
            color: #999;
            text-decoration: line-through;
            margin-left: 10px;
            font-size: 16px;
        }

        .discount-badge {
            background: #28a745;
            color: #fff;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .offer-details-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #fff8e1;
            border: 1px solid #ffd54f;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 10px 0;
        }

        .offer-details-box .offer-icon {
            font-size: 24px;
        }

        .offer-details-box .offer-content {
            flex: 1;
        }

        .offer-details-box .offer-title {
            font-weight: 600;
            color: #e65100;
        }

        .offer-details-box .offer-desc {
            color: #666;
            font-size: 13px;
        }

        .offer-details-box .offer-expiry {
            color: #999;
            font-size: 12px;
            margin-top: 4px;
        }

        .offer-details-box .offer-expiry i {
            margin-right: 4px;
        }

        /* Option Item */
        .option-item {
            cursor: pointer;
            padding: 4px 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin: 3px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .option-item:hover {
            border-color: #000;
            transform: translateY(-2px);
        }

        .option-item.active {
            border-color: #000;
            background: #000;
            color: #fff;
        }

        .color-swatch {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
        }

        .option-item.active .color-swatch {
            border-color: #fff;
        }

        /* Tabs Enhancement */
        .nav-tabs .nav-link {
            color: #666;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-tabs .nav-link:hover {
            color: #000;
            background: #f8f9fa;
        }

        .nav-tabs .nav-link.active {
            color: #000;
            border-bottom: 2px solid #000;
            background: transparent;
        }

        .nav-tabs .nav-link .badge {
            background: #000;
            color: #fff;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 11px;
            margin-left: 5px;
        }

        /* Stock Badge */
        .stock-badge {
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .stock-badge.in-stock {
            background: #d4edda;
            color: #155724;
        }

        .stock-badge.out-stock {
            background: #f8d7da;
            color: #721c24;
        }

        /* More Info List */
        .ec-single-pro-tab-moreinfo ul {
            list-style: none;
            padding: 0;
        }

        .ec-single-pro-tab-moreinfo ul li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }

        .ec-single-pro-tab-moreinfo ul li:last-child {
            border-bottom: none;
        }

        .ec-single-pro-tab-moreinfo ul li span {
            font-weight: 600;
            min-width: 150px;
            color: #333;
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
            color: #fff;
        }
    </style>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ $product->name }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Products</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Sart Single product -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-pro-rightside ec-common-rightside col-lg-12 col-md-12">

                    <!-- Single product content Start -->
                    <div class="single-pro-block">
                        <div class="single-pro-inner">
                            <div class="row">
                                <!-- IMAGE SECTION - UNCHANGED -->
                                <div class="single-pro-img single-pro-img-no-sidebar" wire:ignore>
                                    <div class="single-product-scroll">
                                        {{-- 360 View --}}
                                        {{-- MAIN COVER --}}
                                        <div class="single-product-cover" id="product-cover">
                                            {{-- First image slot → active variant OR default --}}
                                            <div class="single-slide zoom-image-hover">
                                                <img class="img-responsive" id="cover-main"
                                                    src="{{ $activeVariant && $activeVariant->image ? $activeVariant->image : $product->media->where('is_thumbnail', false)->first()->file_path ?? '' }}"
                                                    alt="Main Image">
                                            </div>

                                            {{-- Rest gallery --}}
                                            @foreach ($product->media->where('is_thumbnail', false)->skip(1) as $gal)
                                                <div class="single-slide zoom-image-hover">
                                                    <img class="img-responsive" src="{{ $gal->file_path }}"
                                                        alt="Gallery Image">
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- THUMBNAILS --}}
                                        <div class="single-nav-thumb mt-2" id="product-thumbs">
                                            {{-- First thumb (linked to cover-main) --}}
                                            <div class="single-slide">
                                                <img class="img-responsive" id="thumb-main"
                                                    src="{{ $activeVariant && $activeVariant->image ? $activeVariant->image : $product->media->where('is_thumbnail', false)->first()->file_path ?? '' }}"
                                                    alt="Thumb Image">
                                            </div>

                                            {{-- Rest thumbs --}}
                                            @foreach ($product->media->where('is_thumbnail', false)->skip(1) as $gal)
                                                <div class="single-slide">
                                                    <img class="img-responsive" src="{{ $gal->file_path }}"
                                                        alt="Gallery Thumb">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- PRODUCT INFO -->
                                <div class="single-pro-desc single-pro-desc-no-sidebar">
                                    <div class="single-pro-content">
                                        <h5 class="ec-single-title">{{ $product->name }}</h5>
                                        <div class="ec-single-rating-wrap">
                                            <div class="ec-single-rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($avgRating))
                                                        <i class="ecicon eci-star fill"></i>
                                                    @elseif($i - $avgRating < 1)
                                                        <i class="ecicon eci-star-half-o"></i>
                                                    @else
                                                        <i class="ecicon eci-star-o"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="ec-read-review">
                                                <a href="#" wire:click.prevent="setActiveTab('reviews')">
                                                    {{ $reviewCount }} Reviews
                                                </a>
                                            </span>
                                        </div>
                                        <div class="ec-single-desc">{!! Str::limit($product->description, 150) !!}</div>

                                        <!-- PRICE + STOCK WITH OFFER -->
                                        <div class="ec-single-price-stoke">
                                            {{-- Price Section --}}
                                            <div class="ec-single-price">
                                                @if ($hasOffer)
                                                    <span class="offer-label">
                                                        <i class="ecicon eci-fire"></i>
                                                        {{ $offerDetails->title ?? 'Offer' }}
                                                    </span>
                                                @endif

                                                <span class="ec-single-ps-title">Price</span>

                                                <span id="product-price" class="new-price">
                                                    Rs.{{ number_format($productPrice, 0) }}
                                                </span>

                                                @if ($originalPrice > $productPrice)
                                                    <span class="old-price">
                                                        Rs.{{ number_format($originalPrice, 0) }}
                                                    </span>
                                                    <span class="discount-badge">
                                                        Save {{ $discountPercentage }}%
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Stock + SKU --}}
                                            <div class="ec-single-stoke">
                                                <span class="ec-single-ps-title">
                                                    @if ($activeVariant)
                                                        {{ $activeVariant->stock > 0 ? '✅ IN STOCK' : '❌ OUT OF STOCK' }}
                                                        @if ($activeVariant->stock > 0 && $activeVariant->stock <= 10)
                                                            <small>(Only {{ $activeVariant->stock }} left)</small>
                                                        @endif
                                                    @elseif ($product->track)
                                                        {{ $product->stock > 0 ? '✅ IN STOCK' : '❌ OUT OF STOCK' }}
                                                        @if ($product->stock > 0 && $product->stock <= 10)
                                                            <small>(Only {{ $product->stock }} left)</small>
                                                        @endif
                                                    @endif
                                                </span>

                                                <span class="ec-single-sku">
                                                    SKU#: {{ $activeVariant->sku ?? $product->sku }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- OFFER DETAILS --}}
                                        @if ($hasOffer && $offerDetails)
                                            <div class="offer-details-box">
                                                <div class="offer-icon">🎁</div>
                                                <div class="offer-content">
                                                    <div class="offer-title">{{ $offerDetails->title }}</div>
                                                    <div class="offer-desc">
                                                        {{ $offerDetails->description ?? 'Limited time offer!' }}</div>
                                                    @if ($offerDetails->end_date)
                                                        <div class="offer-expiry">
                                                            <i class="ecicon eci-clock"></i>
                                                            Expires: {{ $offerDetails->end_date->format('M d, Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        {{-- OPTIONS --}}
                                        <div class="ec-pro-variation">
                                            @foreach ($options as $optionName => $values)
                                                <div
                                                    class="ec-pro-variation-inner ec-pro-variation-{{ strtolower($optionName) }}">
                                                    <span>{{ strtoupper($optionName) }}</span>
                                                    <div class="ec-pro-variation-content">
                                                        <ul class="option-list">
                                                            @foreach ($values->unique('value') as $value)
                                                                <li wire:click="selectOption('{{ $optionName }}', {{ $value->id }})"
                                                                    class="option-item {{ isset($selectedOptions[$optionName]) && $selectedOptions[$optionName] == $value->id ? 'active' : '' }}">
                                                                    @if ($value->color_code)
                                                                        <span class="color-swatch"
                                                                            style="background-color:{{ $value->color_code }};"></span>
                                                                    @else
                                                                        <span
                                                                            class="option-pill">{{ $value->value }}</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <style>
                                            .option-list {
                                                display: flex;
                                                flex-wrap: wrap;
                                                gap: 0.5rem;
                                                list-style: none;
                                                padding: 0;
                                                margin: 0;
                                                min-width: 300px;
                                            }

                                            .option-item {
                                                display: inline-flex;
                                                cursor: pointer;
                                                /* no fixed width/height here — let content decide */
                                            }

                                            .option-pill {
                                                display: inline-flex;
                                                align-items: center;
                                                justify-content: center;
                                                padding: 0.5rem 1rem;
                                                white-space: nowrap;
                                                /* stops the clipping */
                                                border: 1px solid #d1d5db;
                                                border-radius: 0.5rem;
                                                font-size: 0.875rem;
                                                font-weight: 500;
                                                color: #374151;
                                                background: #fff;
                                                transition: border-color 0.15s, color 0.15s;
                                            }

                                            .option-item:hover .option-pill {
                                                border-color: #111827;
                                                color: #111827;
                                            }

                                            .option-item.active .option-pill {
                                                border-color: #111827;
                                                background: #111827;
                                                color: #fff;
                                            }

                                            .color-swatch {
                                                display: inline-block;
                                                width: 2rem;
                                                height: 2rem;
                                                border-radius: 9999px;
                                                border: 2px solid #d1d5db;
                                                transition: border-color 0.15s;
                                            }

                                            .option-item.active .color-swatch {
                                                border-color: #6d28d9;
                                                /* matches the purple ring in your screenshot */
                                                box-shadow: 0 0 0 2px #fff, 0 0 0 4px #6d28d9;
                                            }
                                        </style>
                                        {{-- Quantity + Buttons --}}
                                        <div class="ec-single-qty">
                                            <div class="qty-plus-minus">
                                                <div class="dec ec_qtybtn" wire:click="decrement">-</div>
                                                {{ $qty }}
                                                {{-- <input class="qty-input" wire:model="qty" type="text" /> --}}
                                                <div class="inc ec_qtybtn" wire:click="increment">+</div>
                                            </div>

                                            {{-- Add to Cart --}}
                                            <div class="ec-single-cart">
                                                <button class="btn btn-primary"
                                                    wire:click="addCart({{ $product->id }})"
                                                    wire:loading.attr="disabled">
                                                    <span wire:loading.remove><i class="ecicon eci-shopping-bag"></i>
                                                        Add To Cart</span>
                                                    <span wire:loading>Adding...</span>
                                                </button>
                                            </div>

                                            {{-- Buy Now --}}
                                            <div class="ec-single-cart">
                                                <button class="btn btn-secondary"
                                                    wire:click="buyNow({{ $product->id }})"
                                                    wire:loading.attr="disabled">
                                                    <span wire:loading.remove><i class="ecicon eci-bolt"></i> Buy
                                                        Now</span>
                                                    <span wire:loading>Processing...</span>
                                                </button>
                                            </div>

                                            {{-- Wishlist --}}
                                            <div class="ec-single-wishlist active">
                                                @livewire('web.components.wish.button', ['id' => $product->id])
                                            </div>

                                            {{-- Quick View --}}
                                            <div class="ec-single-quickview">
                                                <a href="#" class="ec-btn-group quickview"
                                                    data-link-action="quickview" title="Quick view"
                                                    data-bs-toggle="modal" data-bs-target="#ec_quickview_modal">
                                                    <i class="fi-rr-eye"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="ec-single-social">
                                            <ul class="mb-0">
                                                <li class="list-inline-item facebook"><a href="#"><i
                                                            class="ecicon eci-facebook"></i></a></li>
                                                <li class="list-inline-item twitter"><a href="#"><i
                                                            class="ecicon eci-twitter"></i></a></li>
                                                <li class="list-inline-item instagram"><a href="#"><i
                                                            class="ecicon eci-instagram"></i></a></li>
                                                <li class="list-inline-item youtube-play"><a href="#"><i
                                                            class="ecicon eci-youtube-play"></i></a></li>
                                                <li class="list-inline-item behance"><a href="#"><i
                                                            class="ecicon eci-behance"></i></a></li>
                                                <li class="list-inline-item whatsapp"><a href="#"><i
                                                            class="ecicon eci-whatsapp"></i></a></li>
                                                <li class="list-inline-item plus"><a href="#"><i
                                                            class="ecicon eci-plus"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Single product content End -->

                    <!-- Single product tab start - ENHANCED -->
                    <div class="ec-single-pro-tab">
                        <div class="ec-single-pro-tab-wrapper">
                            <div class="ec-single-pro-tab-nav">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab == 'details' ? 'active' : '' }}"
                                            wire:click="setActiveTab('details')" data-bs-toggle="tab" role="tab">
                                            <i class="ecicon eci-info-circle"></i> Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab == 'info' ? 'active' : '' }}"
                                            wire:click="setActiveTab('info')" data-bs-toggle="tab" role="tab">
                                            <i class="ecicon eci-list-ul"></i> More Information
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab == 'reviews' ? 'active' : '' }}"
                                            wire:click="setActiveTab('reviews')" data-bs-toggle="tab" role="tab">
                                            <i class="ecicon eci-star"></i> Reviews
                                            @if ($reviewCount > 0)
                                                <span class="badge">{{ $reviewCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content ec-single-pro-tab-content">
                                <!-- Details Tab -->
                                <div class="tab-pane fade {{ $activeTab == 'details' ? 'show active' : '' }}"
                                    id="ec-spt-nav-details">
                                    <div class="ec-single-pro-tab-desc">
                                        {!! $product->instructions->content ?? $product->description !!}
                                    </div>
                                </div>

                                <!-- More Information Tab -->
                                <div class="tab-pane fade {{ $activeTab == 'info' ? 'show active' : '' }}"
                                    id="ec-spt-nav-info">
                                    <div class="ec-single-pro-tab-moreinfo">
                                        <ul>
                                            @if ($product->brand)
                                                <li><span>Brand</span> {{ $product->brand->name }}</li>
                                            @endif
                                            <li><span>SKU</span> {{ $product->sku }}</li>
                                            @if ($product->ingredients->count() > 0)
                                                @foreach ($product->ingredients as $ing)
                                                    <li><span>{{ $ing->name }}</span> {{ $ing->percentage . '%' }}
                                                        ({{ $ing->benefit }})
                                                    </li>
                                                @endforeach
                                            @endif
                                            @if ($hasOffer && $offerDetails)
                                                <li><span>Offer</span> {{ $offerDetails->title }}
                                                    @if ($offerDetails->discount_type === 'percentage')
                                                        ({{ $offerDetails->discount_value }}% OFF)
                                                    @elseif($offerDetails->discount_type === 'fixed')
                                                        (Rs. {{ $offerDetails->discount_value }} OFF)
                                                    @endif
                                                </li>
                                                @if ($offerDetails->end_date)
                                                    <li><span>Offer Expires</span>
                                                        {{ $offerDetails->end_date->format('M d, Y') }}</li>
                                                @endif
                                            @endif
                                            <li><span>Stock</span>
                                                <span
                                                    class="stock-badge {{ ($activeVariant ? $activeVariant->stock : $product->stock) > 0 ? 'in-stock' : 'out-stock' }}">
                                                    {{ ($activeVariant ? $activeVariant->stock : $product->stock) > 0 ? 'In Stock' : 'Out of Stock' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Reviews Tab -->
                                <div class="tab-pane fade {{ $activeTab == 'reviews' ? 'show active' : '' }}"
                                    id="ec-spt-nav-review">
                                    @livewire('web.components.single.rating-component', ['id' => $product->id])
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details description area end -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Single product -->

    <!-- Related Product Start -->
    <section class="section ec-releted-product section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Related products</h2>
                        <h2 class="ec-title">Related products</h2>
                        <p class="sub-title">Browse The Collection of Top Products</p>
                    </div>
                </div>
            </div>
            <div class="row margin-minus-b-30">
                <!-- Related Product Content -->
                @livewire('web.components.single.related-products', ['id' => $product->id])
            </div>
        </div>
    </section>
    <!-- Related Product end -->

</div>



<script>
    window.addEventListener('variant-selected', event => {
        const image = event.detail.image;
        if (!image) return;

        document.getElementById('cover-main').src = image;
        document.getElementById('thumb-main').src = image;

        $('#product-cover').slick('slickGoTo', 0);
        $('#product-thumbs').slick('slickGoTo', 0);
    });

    document.addEventListener("DOMContentLoaded", function() {
        $('#product-cover').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: '#product-thumbs'
        });

        $('#product-thumbs').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '#product-cover',
            focusOnSelect: true
        });
    });
</script>
