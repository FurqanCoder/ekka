@props(['product', 'name'])

@php
    $options = $product->optionValuesByName($name);
    $thumbnail = optional($product->media->where('is_thumbnail', true)->first())->file_path
        ?? asset('images/default.png');
@endphp

@if ($options->isNotEmpty())
    <div class="ec-pro-{{ strtolower($name) }}">
        <span class="ec-pro-opt-label">{{ $name }}</span>
        <ul class="ec-opt-{{ strtolower($name) }}">
            @foreach ($options as $option)
                @php
                    // find the first variant that uses this option value
                    $variant = $product->variants->first(
                        fn($v) => $v->optionValues->contains('id', $option->id)
                    );

                    // if variant has an image, use it; otherwise fallback to product thumbnail
                    $img = $variant && $variant->image ? $variant->image : $thumbnail;

                    $oldPrice = $variant->price ?? ($product->prices->base_price ?? 0);
                    $newPrice = $variant->price ?? ($product->prices->final_price ?? $oldPrice);
                @endphp

                @if ($option->color_code) 
                    {{-- Render as color swatch --}}
                    <li>
                        <a href="#" class="ec-opt-clr-img"
                           data-src="{{ $img }}"
                           data-src-hover="{{ $img }}"
                           data-tooltip="{{ $option->value }}">
                            <span style="background-color: {{ $option->color_code }};
                                         width:20px; height:20px; border-radius:50%;
                                         display:inline-block;"></span>
                        </a>
                    </li>
                @else
                    {{-- Render as text (Size, Material, etc.) --}}
                    <li>
                        <a href="#" class="ec-opt-sz"
                           data-old="${{ number_format($oldPrice, 2) }}"
                           data-new="${{ number_format($newPrice, 2) }}"
                           data-tooltip="{{ $option->value }}">
                            {{ $option->value }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
