@props([
    'product',
    'col' => 3,
    'showActions' => false,
    'addCartMethod' => null,
    'wishMethod' => null,
    'quickViewMethod' => null,
])

@php
    // Images
    $thumbnail = optional($product->media->where('is_thumbnail', true)->first())->file_path
        ?? asset('images/default.png');

    $hoverImage = optional($product->media->where('is_thumbnail', false)->first())->file_path
        ?? $thumbnail;

    // Prices
    $oldPrice = optional($product->prices)->base_price
        ?? $product->variants->min('base_price');

    $newPrice = optional($product->prices)->final_price
        ?? $product->variants->min('price');

    // Variant Option Values
    $optionValues = $product->variants->flatMap->optionValues;

    // Colors
    $colorOptions = $optionValues
        ->filter(fn($v) => strtolower($v->option->name) === 'color')
        ->unique(fn($v) => $v->color_code ?: $v->value);

    // Sizes (Material)
    $sizeOptions = $optionValues
        ->filter(fn($v) => strtolower($v->option->name) === 'material')
        ->unique('value');
@endphp

<div class="col-lg-{{ $col}} 6 col-sm-6 col-xs-6 mb-6 ec-product-content" data-animation="flipInY">

    <div class="ec-product-inner">

        {{-- Product Images --}}
        <div class="ec-pro-image-outer">
            <div class="ec-pro-image">
                <a href="{{ route('web-product', $product->slug) }}" class="image">
                    <img class="main-image img-fluid"
                         src="{{ $thumbnail }}"
                         alt="{{ $product->name }}"
                         style="max-height: 285px; width:100%; object-fit: cover;">

                    <img class="hover-image img-fluid"
                         src="{{ $hoverImage }}"
                         alt="{{ $product->name }}">
                </a>

                {{-- Discount --}}
                @if (optional($product->prices)->discount_value > 0)
                    <span class="flags">
                        <span class="sale bg-danger">@if (optional($product->prices)->discount_type === 'percent')
                                                                {{ intval(optional($product->prices)->discount_value) }}% OFF
                                                            @elseif(optional($product->prices)->discount_type === 'fixed')
                                                                {{ intval(optional($product->prices)->discount_value) }} Rs OFF
                                                            @endif</span>
                    </span>
                @endif

                {{-- Action Buttons --}}
               @if ($showActions)
                   <div class="ec-pro-actions">
                       @if ($quickViewMethod)
                           <button type="button" wire:click.prevent="{{ $quickViewMethod }}({{ $product->id }})" class="ec-btn-group compare" title="Quick View">
                               <i class="fi-rr-eye"></i>
                           </button>
                       @else
                           <a class="ec-btn-group compare" href="{{ route('web-product', $product->slug) }}" title="Quick View">
                               <i class="fi-rr-eye"></i>
                           </a>
                       @endif

                       @if ($addCartMethod)
                           <button type="button" wire:click.prevent="{{ $addCartMethod }}({{ $product->id }})" title="Add To Cart" class="add-to-cart">
                               <i class="fi-rr-shopping-basket"></i> Add To Cart
                           </button>
                       @else
                           <a href="{{ route('web-product', $product->slug) }}" title="Add To Cart" class="add-to-cart">
                               <i class="fi-rr-shopping-basket"></i> Add To Cart
                           </a>
                       @endif

                       @if ($wishMethod)
                           <button type="button" wire:click.prevent="{{ $wishMethod }}({{ $product->id }})" title="Wishlist" class="ec-btn-group wishlist @if($inWishlist ?? false) active @endif">
                               <i class="fi-rr-heart"></i>
                           </button>
                       @else
                           <a class="ec-btn-group wishlist" href="{{ route('web.wish') }}" title="Wishlist">
                               <i class="fi-rr-heart"></i>
                           </a>
                       @endif
                   </div>
               @endif
 
            </div>
        </div>

        {{-- Product Content --}}
        <div class="ec-pro-content">

            {{-- Title --}}
            <h5 class="ec-pro-title">
                <a href="{{ route('web-product', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h5>

            {{-- Rating (Static for Now) --}}
            <div class="ec-pro-rating">
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star"></i>
            </div>

            {{-- Prices --}}
            <span class="ec-price">
                <span class="old-price">Rs.{{ $oldPrice }}</span>
                <span class="new-price">Rs.{{ $newPrice }}</span>
            </span>

            {{-- Options --}}
            <div class="ec-pro-option">

                {{-- Colors --}}
                @if ($colorOptions->isNotEmpty())
                    <div class="ec-pro-color">
                        <span class="ec-pro-opt-label">Color</span>
                        <ul class="ec-opt-swatch ec-change-img">
                            @foreach ($colorOptions as $color)
                                @php
                                    $variant = $product->variants->first(
                                        fn($v) => $v->optionValues->contains('id', $color->id)
                                    );
                                    $vImg = $variant?->image ?? $thumbnail;
                                @endphp

                                <li>
                                    <a href="#"
                                       class="ec-opt-clr-img"
                                       data-src="{{ $vImg }}"
                                       data-src-hover="{{ $vImg }}"
                                       data-tooltip="{{ $color->value }}">
                                        <span class="rounded-circle"
                                              style="background: {{ $color->color_code ?? '#ccc' }};
                                                     width:20px;
                                                     height:20px;
                                                     display:inline-block;">
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Sizes --}}
                @if ($sizeOptions->isNotEmpty())
                    <div class="ec-pro-size">
                        <span class="ec-pro-opt-label">Size</span>
                        <ul class="ec-opt-size">
                            @foreach ($sizeOptions as $size)
                                <li>
                                    <a href="#"
                                       class="ec-opt-sz"
                                       data-tooltip="{{ $size->value }}">
                                        {{ $size->value }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
