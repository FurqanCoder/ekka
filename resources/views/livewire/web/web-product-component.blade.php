<div>


    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ $product->name }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Products</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
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
                                <div class="single-pro-img single-pro-img-no-sidebar" wire:ignore>
                                    <div class="single-product-scroll">
                                        {{-- 360 View --}}
                                        <a class="ec-360-lbl" title="360 view" data-bs-toggle="modal"
                                            data-bs-target="#ec_360_view_modal">
                                            <img src="{{ asset('web/images/icons/360-degrees.png') }}" alt="360">
                                        </a>

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
                                <div class="single-pro-desc single-pro-desc-no-sidebar">
                                    <div class="single-pro-content">
                                        <h5 class="ec-single-title">{{ $product->name }}</h5>
                                        <div class="ec-single-rating-wrap">
                                            <div class="ec-single-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star-o"></i>
                                            </div>
                                            <span class="ec-read-review"><a href="#ec-spt-nav-review">Be the first to
                                                    review this product</a></span>
                                        </div>
                                        <div class="ec-single-desc">{!! $product->description !!} Lorem ipsum dolor, sit amet
                                            consectetur adipisicing elit. Cupiditate quae ipsum illum, maxime, commodi
                                            veniam dolore nobis explicabo minima aut aliquid fuga ad dignissimos
                                            reprehenderit corrupti voluptatem, blanditiis nesciunt molestiae.</div>

                                        {{-- <div class="ec-single-sales">
                                            <div class="ec-single-sales-inner">
                                                <div class="ec-single-sales-title">sales accelerators</div>
                                                <div class="ec-single-sales-visitor">real time <span>24</span> visitor
                                                    right now!</div>
                                                <div class="ec-single-sales-progress">
                                                    <span class="ec-single-progress-desc">Hurry up!left 29 in
                                                        stock</span>
                                                    <span class="ec-single-progressbar"></span>
                                                </div>
                                                <div class="ec-single-sales-countdown">
                                                    <div class="ec-single-countdown"><span
                                                            id="ec-single-countdown"></span></div>
                                                    <div class="ec-single-count-desc">Time is Running Out!</div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        {{-- <div> --}}
                                        {{-- PRICE + STOCK --}}
                                        <div class="ec-single-price-stoke">
                                            {{-- Price Section --}}
                                            <div class="ec-single-price">
                                                <span class="ec-single-ps-title">As low as
                                                    <b>
                                                        @if ($product->prices)
                                                            @if ($product->prices->discount_type === 'percent')
                                                                {{ $product->prices->discount_value }}% OFF
                                                            @elseif($product->prices->discount_type === 'fixed')
                                                                {{ $product->prices->discount_value }} Rs OFF
                                                            @endif
                                                        @else
                                                            N/A
                                                        @endif
                                                    </b>
                                                </span>

                                                <span id="product-price" class="new-price">
                                                    @if ($activeVariant)
                                                        Rs.{{ number_format($activeVariant->price, 2) }}
                                                    @elseif ($product->variants->count() > 0)
                                                        Rs.{{ number_format($product->variants->min('price'), 2) }}
                                                    @else
                                                        Rs.{{ $product->prices->final_price ?? '0.00' }}
                                                    @endif
                                                </span>
                                            </div>

                                            {{-- Stock + SKU --}}
                                            <div class="ec-single-stoke">
                                                <span class="ec-single-ps-title">
                                                    @if ($activeVariant)
                                                        {{ $activeVariant->stock > 0 ? 'IN STOCK' : 'OUT OF STOCK' }}
                                                    @elseif ($product->track)
                                                        {{ $product->stock > 0 ? 'IN STOCK' : 'OUT OF STOCK' }}
                                                    @endif
                                                </span>

                                                <span class="ec-single-sku">
                                                    SKU#: {{ $activeVariant->sku ?? $product->sku }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- OPTIONS --}}
                                        <div class="ec-pro-variation">
                                            @foreach ($options as $optionName => $values)
                                                <div
                                                    class="ec-pro-variation-inner ec-pro-variation-{{ strtolower($optionName) }}">
                                                    <span>{{ strtoupper($optionName) }}</span>
                                                    <div class="ec-pro-variation-content">
                                                        <ul>
                                                            @foreach ($values->unique('value') as $value)
                                                                <li wire:click="selectOption('{{ $optionName }}', {{ $value->id }})"
                                                                    style="
                                    cursor:pointer; 
                                    width: fit-content; 
                                    border:2px solid {{ isset($selectedOptions[$optionName]) && $selectedOptions[$optionName] == $value->id ? '#000' : '#ddd' }};
                                    padding:4px; 
                                    border-radius:5px;
                                    margin:3px;
                                    ">
                                                                    @if ($value->color_code)
                                                                        <span
                                                                            style="width: 20px !important;height:20px; padding: 0;border-radius:50%;background-color:{{ $value->color_code }};"></span>
                                                                    @else
                                                                        <span>{{ $value->value }}</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Quantity + Buttons --}}
                                        <div class="ec-single-qty">
                                            <div class="qty-plus-minus">
                                                <div class="dec ec_qtybtn" wire:click="decrement">-</div>
                                                <input class="qty-input" wire:model="qty" type="text" />
                                                <div class="inc ec_qtybtn" wire:click="increment">+</div>
                                            </div>

                                            {{-- Add to Cart --}}
                                            <div class="ec-single-cart">
                                                <button class="btn btn-primary"
                                                    wire:click="addCart({{ $product->id }})">
                                                    Add To Cart
                                                </button>
                                            </div>
                                            {{-- Buy Now --}}
                                            <div class="ec-single-cart">
                                                <button class="btn btn-primary"
                                                    wire:click="buyNow({{ $product->id }})">
                                                    Buy Now
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
                    <!-- Single product tab start -->
                    <div class="ec-single-pro-tab">
                        <div class="ec-single-pro-tab-wrapper">
                            <div class="ec-single-pro-tab-nav">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#ec-spt-nav-details" role="tab"
                                            aria-controls="ec-spt-nav-details" aria-selected="true">Detail</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-info"
                                            role="tab" aria-controls="ec-spt-nav-info" aria-selected="false">More
                                            Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-review"
                                            role="tab" aria-controls="ec-spt-nav-review"
                                            aria-selected="false">Reviews</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content  ec-single-pro-tab-content">
                                <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                    <div class="ec-single-pro-tab-desc">
                                        {!! $product->instructions->content !!}
                                    </div>
                                </div>
                                <div id="ec-spt-nav-info" class="tab-pane fade">
                                    <div class="ec-single-pro-tab-moreinfo">
                                        <ul>
                                            @foreach ($product->ingredients as $ing)
                                                <li><span>{{ $ing->name }}</span> {{ $ing->percentage . '%' }}
                                                    ({{ $ing->benefit }})</li>
                                            @endforeach
                                            {{-- <li><span>Weight</span> 1000 g</li>
                                            <li><span>Dimensions</span> 35 × 30 × 7 cm</li>
                                            <li><span>Color</span> Black, Pink, Red, White</li> --}}
                                        </ul>
                                    </div>
                                </div>

                                @livewire('web.components.single.rating-component', ['id' => $product->id])
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
        // Access the data using event.detail
        console.log(event.detail.image);
        const image = event.detail.image;
        if (!image) return;

        // Replace cover + thumb
        document.getElementById('cover-main').src = image;
        document.getElementById('thumb-main').src = image;

        // Reset to first slide
        $('#product-cover').slick('slickGoTo', 0);
        $('#product-thumbs').slick('slickGoTo', 0);
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Init Slick once
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

        // Listen for variant change events
        window.addEventListener('variant-selected', function(e) {
            console.log(e.detail.image);

            const image = e.detail.image;
            if (!image) return;

            // Replace cover + thumb
            document.getElementById('cover-main').src = image;
            document.getElementById('thumb-main').src = image;

            // Reset to first slide
            $('#product-cover').slick('slickGoTo', 0);
            $('#product-thumbs').slick('slickGoTo', 0);
        });
    });
    let toast = document.getElementById('toast');
    toast.addEventListener("click", function() {
        Toastify({
            text: "This is a toast",
            className: "info",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
        }).showToast();
    })
</script>
