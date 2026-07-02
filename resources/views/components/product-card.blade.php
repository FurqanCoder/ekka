@props(['product', 'col' => 3,])

@php
    // Images
    $thumbnail = $product->media->where('is_thumbnail', true)->first()->file_path
        ?? asset('images/default.png');

    $hoverImage = $product->media->where('is_thumbnail', false)->first()->file_path
        ?? $thumbnail;

    // Prices
    $oldPrice = $product->prices->base_price
        ?? $product->variants->min('base_price');

    $newPrice = $product->prices->final_price
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
                @if ($product->prices->discount_value > 0)
                    <span class="flags">
                        <span class="sale bg-danger">@if ($product->prices->discount_type === 'percent')
                                                                {{ intval($product->prices->discount_value) }}% OFF
                                                            @elseif($product->prices->discount_type === 'fixed')
                                                                {{ intval($product->prices->discount_value) }} Rs OFF
                                                            @endif</span>
                    </span>
                @endif

                {{-- Action Buttons --}}
                <div class="ec-pro-actions">
                    @livewire('web.components.quick-view', ['id' => $product->id])
                    @livewire('web.components.add-cart-button', ['id' => $product->id])
                    @livewire('web.components.wish.button', ['id' => $product->id])
                </div>

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
