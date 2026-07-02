<div>
    @if ($product)
        <div class="modal fade" id="ec_quickview_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Images --}}
                            <div class="col-md-6" wire:ignore>
                                @php
                                    $media = $product->media->where('is_thumbnail', false);
                                    $coverImage = $activeVariant->image ?? $media->first()->file_path ?? '';
                                @endphp
                                <div class="single-product-cover">
                                    <div class="single-slide">
                                        <img src="{{ $coverImage }}" alt="Main Image" class="img-responsive">
                                    </div>
                                    @foreach ($media->skip(1) as $gal)
                                        <div class="single-slide">
                                            <img src="{{ $gal->file_path }}" alt="Gallery Image" class="img-responsive">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="single-nav-thumb mt-2">
                                    <div class="single-slide"><img src="{{ $coverImage }}" alt="Thumb"></div>
                                    @foreach ($media->skip(1) as $gal)
                                        <div class="single-slide"><img src="{{ $gal->file_path }}" alt="Thumb"></div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Product Info --}}
                            <div class="col-md-6">
                                <h5>{{ $product->name }}</h5>
                                <p>{!! $product->description !!}</p>

                                {{-- Price --}}
                                <div>
                                    @if ($activeVariant)
                                        Rs.{{ number_format($activeVariant->price,2) }}
                                    @elseif($product->variants && $product->variants->count() > 0)
                                        Rs.{{ number_format($product->variants->min('price'),2) }}
                                    @else
                                        Rs.{{ $product->prices->final_price ?? '0.00' }}
                                    @endif
                                </div>

                                {{-- Options --}}
                                @if ($options->count() > 0)
                                    @foreach ($options as $optionName => $values)
                                        <div class="mb-2">
                                            <strong>{{ strtoupper($optionName) }}:</strong>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($values->unique('value') as $value)
                                                    <div wire:click="selectOption('{{ $optionName }}', {{ $value->id }})"
                                                         class="p-1 me-1 mb-1"
                                                         style="border:2px solid {{ isset($selectedOptions[$optionName]) && $selectedOptions[$optionName]==$value->id ? '#000' : '#ddd' }}; border-radius:5px; cursor:pointer;">
                                                        @if ($value->color_code)
                                                            <span style="display:inline-block;width:20px;height:20px;border-radius:50%;background-color:{{ $value->color_code }}"></span>
                                                        @else
                                                            {{ $value->value }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- Quantity + Add to Cart --}}
                                <div class="mt-3 d-flex align-items-center">
                                    <button wire:click="decrement" class="btn btn-light">-</button>
                                    <input type="text" wire:model="qty" class="form-control mx-1" style="width:60px;">
                                    <button wire:click="increment" class="btn btn-light">+</button>
                                    <button wire:click="addCart({{ $product->id }})" class="btn btn-primary ms-2">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
