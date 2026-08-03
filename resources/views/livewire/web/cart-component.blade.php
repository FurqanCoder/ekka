<div>
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <!-- Ec cart page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-cart-leftside col-lg-8 col-md-12 ">
                    <!-- cart content Start -->
                    <div class="ec-cart-content">
                        <div class="ec-cart-inner">
                            <div class="row">
                                <form action="#">
                                    <div class="table-content cart-table-content">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th style="text-align: center;">Quantity</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($cart as $item)
                                                    @php
                                                        $product = $item['product'];
                                                        $variant = $item['variant'];
                                                        $img =
                                                            optional($product->media->first()) ??
                                                            asset('images/placeholder.png');

                                                        $name = $product->name ?? 'Unknown product';
                                                        $price =
                                                            $variant->price ?? ($product->prices->final_price ?? 0);
                                                    @endphp
                                                    <tr>
                                                        <td data-label="Product" class="ec-cart-pro-name"><a
                                                                href="product-left-sidebar.html"><img
                                                                    class="ec-cart-pro-img mr-4"
                                                                    src="{{ $img->file_path }}"
                                                                    alt="{{ $name }}" />{{ $name }}</a>
                                                        </td>
                                                        <td data-label="Price" class="ec-cart-pro-price"><span
                                                                class="amount">Rs.{{ number_format($price, 2) }}</span>
                                                        </td>
                                                        <td data-label="Quantity" style="text-align:center;">
                                                            <div
                                                                style="display:flex; align-items:center; justify-content:center; gap:3px;font-size:small">
                                                                <button type="button"
                                                                    wire:click="decrementQty({{ $item['product_id'] }}, {{ $item['variant_id'] ?? 'null' }})"
                                                                    style="border:1px solid #ccc; background:#fff; padding:2px 8px; cursor:pointer;">
                                                                    −
                                                                </button>

                                                                <span
                                                                    style="display:inline-block; border:1px solid #ccc; padding:2px 12px; min-width:30px; text-align:center;">
                                                                    {{ $item['quantity'] }}
                                                                </span>

                                                                <button type="button"
                                                                    wire:click="incrementQty({{ $item['product_id'] }}, {{ $item['variant_id'] ?? 'null' }})"
                                                                    style="border:1px solid #ccc; background:#fff; padding:2px 8px; cursor:pointer;">
                                                                    +
                                                                </button>
                                                            </div>
                                                        </td>

                                                        <td data-label="Total" class="ec-cart-pro-subtotal">Rs.
                                                            {{ number_format($price * $item['quantity'], 2) }}</td>
                                                        <td data-label="Remove" class="ec-cart-pro-remove">
                                                            <a wire:click="removeItem({{ $item['product_id'] }}, {{ $item['variant_id'] ?? 'null' }})"><i class="ecicon eci-trash-o"></i></a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>No items in cart</tr>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ec-cart-update-bottom">
                                                <a href="#">Continue Shopping</a>
                                                <button class="btn btn-primary">Check Out</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--cart content End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-cart-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Summary</h3>
                            </div>
                            {{-- <div class="ec-sb-block-content">
                                <h4 class="ec-ship-title">Estimate Shipping</h4>
                                <div class="ec-cart-form">
                                    <p>Enter your destination to get a shipping estimate</p>
                                    <form action="#" method="post">
                                        <span class="ec-cart-wrap">
                                            <label>Country *</label>
                                            <span class="ec-cart-select-inner">
                                                <select name="ec_cart_country" id="ec-cart-select-country"
                                                    class="ec-cart-select">
                                                    <option selected="" disabled="">United States</option>
                                                    <option value="1">Country 1</option>
                                                    <option value="2">Country 2</option>
                                                    <option value="3">Country 3</option>
                                                    <option value="4">Country 4</option>
                                                    <option value="5">Country 5</option>
                                                </select>
                                            </span>
                                        </span>
                                        <span class="ec-cart-wrap">
                                            <label>State/Province</label>
                                            <span class="ec-cart-select-inner">
                                                <select name="ec_cart_state" id="ec-cart-select-state"
                                                    class="ec-cart-select">
                                                    <option selected="" disabled="">Please Select a region, state
                                                    </option>
                                                    <option value="1">Region/State 1</option>
                                                    <option value="2">Region/State 2</option>
                                                    <option value="3">Region/State 3</option>
                                                    <option value="4">Region/State 4</option>
                                                    <option value="5">Region/State 5</option>
                                                </select>
                                            </span>
                                        </span>
                                        <span class="ec-cart-wrap">
                                            <label>Zip/Postal Code</label>
                                            <input type="text" name="postalcode" placeholder="Zip/Postal Code">
                                        </span>
                                    </form>
                                </div>
                            </div> --}}

                            <div class="ec-sb-block-content">
                                <div class="ec-cart-summary-bottom">
                                    <div class="ec-cart-summary">
                                        <div>
                                            <span class="text-left">Sub-Total</span>
                                            <span class="text-right">Rs. {{ number_format($subtotal, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-left">Delivery Charges</span>
                                            <span class="text-right">Rs. 0</span>
                                        </div>
                                        @livewire('web.components.cart-coupon-component')
                                        <div class="ec-cart-summary-total">
                                            <span class="text-left">Total Amount</span>
                                            <span class="text-right">Rs. {{ number_format($subtotal, 2) }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
