<div>
    <!-- ekka Cart Start -->
    <div class="ec-side-cart-overlay"></div>
    <div id="ec-side-cart" class="ec-side-cart" wire:ignore.self>
        <div class="ec-cart-inner">
            <div class="ec-cart-top">
                <div class="ec-cart-title">
                    <span class="cart_title">My Cart</span>
                    <button class="ec-close">×</button>
                </div>

                <ul class="eccart-pro-items">
                    {{-- @if (isset($cart)) --}}
                    @forelse ($cart as $item)
                        @php
                            $product = $item['product'];
                            $variant = $item['variant'];
                            $img = optional($product->media->first()) ?? asset('images/placeholder.png');

                            $name = $product->name ?? 'Unknown product';
                            $price = $variant->price ?? ($product->prices->final_price ?? 0);
                        @endphp
                        <li>
                            <a href="{{ $product ? route('web-product', $product->slug) : 'javascript:void(0)' }}"
                                class="sidekka_pro_img">
                                <img src="{{ $img->file_path }}" alt="{{ $name }}">
                            </a>
                            <div class="ec-pro-content">
                                <a href="{{ $product ? route('web-product', $product->slug) : 'javascript:void(0)' }}"
                                    class="cart_pro_title">{{ $name }}</a>
                                <span class="cart-price"><span>Rs.{{ number_format($price, 2) }}</span> x
                                    {{ $item['quantity'] }}</span>
                                <div class="qty-plus-minus" wire:ignore.self>
                                    <div class="qty-plus-minus">
                                        <div class="dec ec_qtybtn"
                                            wire:click="decrementQty({{ $item['product_id'] }}, {{ $item['variant_id'] ?? 'null' }})">
                                            -</div>

                                        <input class="qty-input" type="text" value="{{ $item['quantity'] }}"
                                            readonly />

                                        <div class="inc ec_qtybtn"
                                            wire:click="incrementQty({{ $item['product_id'] }}, {{ $item['variant_id'] ?? 'null' }})">
                                            +</div>
                                    </div>

                                </div>
                                <a href="javascript:void(0)"
                                    wire:click="removeItem({{ $item['product_id'] }}, {{ $item['variant_id'] ?? 'null' }})"
                                    class="remove">×</a>
                            </div>
                        </li>
                    @empty
                        <li>No items in cart</li>
                    @endforelse
                    {{-- @endif --}}

                </ul>
            </div>

            <div class="ec-cart-bottom">
                {{-- Optionally show subtotal, VAT etc. compute them in the component if needed --}}
                <div class="cart-sub-total">
                    <table class="table cart-table">
                        <tbody>
                            <tr>
                                <td class="text-left">Sub-Total :</td>
                                <td class="text-right">Rs. {{ number_format($subtotal, 2) }}</td>
                            </tr>
                            {{-- <tr>
                                <td class="text-left">VAT (20%) :</td>
                                <td class="text-right">$60.00</td>
                            </tr> --}}
                            {{-- <tr>
                                <td class="text-left">Total :</td>
                                <td class="text-right primary-color">$360.00</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                <div class="cart_btn">
                    <a href="" class="btn btn-primary">View Cart</a>
                    <a href="" class="btn btn-secondary">Checkout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ekka Cart End -->
</div>
