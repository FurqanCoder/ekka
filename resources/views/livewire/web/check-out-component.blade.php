<div>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Checkout</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="ec-breadcrumb-item active">Checkout</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="checkout-section py-5">
        <div class="container">
            <div class="row">
                <!-- Left: Checkout Steps -->
                <div class="ec-checkout-leftside col-lg-8 col-md-12 ">
                    <div class="checkout-steps p-4 bg-white border">
                        <!-- Step Tabs -->
                        <ul class="nav nav-tabs mb-4" id="checkoutTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'shipping' ? 'active' : '' }}"
                                    id="shipping-tab" wire:click="tabShow('shipping')">Shipping</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link {{ $activeTab == 'payment' ? 'active' : '' }} {{ !session('activeAddress') ? 'disabled' : '' }}"
                                    id="payment-tab"
                                    @if (session('activeAddress')) wire:click="tabShow('payment')" @else title="Select address first" @endif>Payment</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link {{ $activeTab == 'review' ? 'active' : '' }} {{ !(session('activeAddress') && (session('pay_method') || $payment_method)) ? 'disabled' : '' }}"
                                    id="review-tab"
                                    @if (session('activeAddress') && (session('pay_method') || $payment_method)) wire:click="tabShow('review')" @else title="Complete previous steps" @endif>Review</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="checkoutTabsContent">
                            <!-- Shipping Tab -->
                            @switch($activeTab)
                                @case('shipping')
                                    @livewire('web.components.address-manager')
                                @break

                                @case('payment')
                                    <div>
                                        <h4 class="font-semibold mb-3">Select Payment Method</h4>

                                        @foreach ($paymentMethods as $method)
                                            <label class="block mb-3 cursor-pointer">
                                                <input type="radio" name="payment_method" value="{{ $method['key'] }}"
                                                    wire:model="payment_method"
                                                    @if (isset($method['disabled']) && $method['disabled']) disabled @endif />
                                                <span class="ml-2 font-medium">{{ $method['name'] }}</span>
                                                <p class="ml-6 text-sm text-gray-500">{{ $method['description'] }}</p>
                                            </label>
                                        @endforeach

                                        @error('payment_method')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror

                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-primary px-4"
                                                wire:click="tabShow('shipping')">Back</button>
                                            <button class="btn btn-primary px-5" wire:click="goToReview">Review Order</button>
                                        </div>
                                    </div>
                                @break

                                @case('review')
                                    <div id="review">
                                        <h5 class="mb-3">Review & Confirm</h5>

                                        <div class="border rounded p-3 mb-4">
                                            <p class="mb-1">
                                                <strong>Shipping:</strong>
                                                @if ($address)
                                                    {{ $address->name }} — {{ $address->phone }}<br>
                                                    {{ $address->full_address }}
                                                @else
                                                    <em>No shipping address selected</em>
                                                @endif
                                            </p>

                                            <p class="mb-1"><strong>Payment:</strong>
                                                {{ $activePayment ?? session('pay_method') }}</p>

                                            <p class="mb-1"><strong>Sub-Total:</strong> Rs. {{ number_format($subtotal, 2) }}
                                            </p>
                                            <p class="mb-1"><strong>Shipping:</strong> Rs.
                                                {{ number_format($shippingCost, 2) }}</p>
                                            @if (session('applied_coupon.discount'))
                                                <p class="mb-1"><strong>Discount:</strong> - Rs.
                                                    {{ number_format(session('applied_coupon.discount'), 2) }}</p>
                                            @endif
                                            <p class="mb-0"><strong>Total:</strong> <span
                                                    class="text-primary">{{ 'Rs.' . number_format($total, 2) }}</span></p>
                                        </div>

                                        <!-- order items -->
                                        <div class="mb-3">
                                            <h6>Items</h6>
                                            @foreach ($cart as $item)
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div>
                                                        <strong>{{ $item['name'] }}</strong>
                                                        @if ($item['variant_options'])
                                                            <div class="text-muted small">{{ $item['variant_options'] }}</div>
                                                        @endif
                                                        <div class="small text-muted">Qty: {{ $item['qty'] }}</div>
                                                    </div>
                                                    <div>Rs. {{ number_format($item['price'] * $item['qty'], 2) }}</div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="text-center mt-4">
                                            <button class="btn btn-success px-5 py-2" wire:click="placeOrder"
                                                wire:loading.attr="disabled" wire:target="placeOrder"
                                                @if ($placing) disabled @endif>
                                                <i class="bi bi-lock-fill me-2"></i>
                                                <span wire:loading.remove wire:target="placeOrder">Place Order Securely</span>
                                                <span wire:loading wire:target="placeOrder">Placing...</span>
                                            </button>
                                        </div>

                                        <div class="text-center mt-3">
                                            <small class="text-muted">🔒 100% Secure Checkout • 💳 SSL Encrypted • 🛡️
                                                Money-Back Guarantee</small>
                                        </div>
                                    </div>
                                @break

                            @endswitch

                            <button wire:click="thanks" class="d-none">thanks</button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Area Start -->
                <div class="ec-checkout-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Summary</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-summary mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Sub-Total</span>
                                        <span>Rs. {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Delivery Charges</span>
                                        <span>Rs. {{ number_format($shippingCost, 2) }}</span>
                                    </div>

                                    @livewire('web.components.cart-coupon-component')

                                    <div class="ec-checkout-summary-total mt-3 d-flex justify-content-between">
                                        <span><strong>Total Amount</strong></span>
                                        <span><strong>Rs. {{ number_format($total, 2) }}</strong></span>
                                    </div>
                                </div>

                                <div class="ec-checkout-pro">
                                    @forelse ($cart as $item)
                                        @php
                                            $product = $item['product'];
                                            $img = optional($product->media->first());
                                            $name = $product->name ?? 'Unknown product';
                                            $price = $item['price'] ?? 0;
                                        @endphp
                                        <div class="col-sm-12 mb-3 d-flex align-items-center">
                                            <div
                                                style="width:64px; height:64px; overflow:hidden; border-radius:8px; margin-right:12px;">
                                                <img src="{{ $img?->file_path ?? asset('images/placeholder.png') }}"
                                                    style="width:100%;height:100%;object-fit:cover;"
                                                    alt="{{ $name }}">
                                            </div>
                                            <div style="flex:1;">
                                                <h6 class="mb-0">{{ $name }}</h6>
                                                <small class="text-muted">Qty. {{ $item['qty'] }}</small>
                                            </div>
                                            <div>Rs. {{ number_format($price * $item['qty'], 2) }}</div>
                                        </div>
                                    @empty
                                        <p class="text-muted">No items in cart.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Thank You Modal (triggered from Livewire) -->
    <div class="modal fade" id="orderConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-body text-center p-5" style="background-color: #ffffff;">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="mx-auto mb-4"
                        style="width:100px; height:100px; border-radius:50%; background-color:#34d399; display:flex; justify-content:center; align-items:center; box-shadow:0 5px 20px rgba(0,0,0,0.15); transform: scale(0); animation: scaleTick 0.5s forwards;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"
                            style="width:50px; height:50px; stroke:white; stroke-width:5; stroke-linecap:round; stroke-linejoin:round; fill:none;">
                            <path class="tick-path" d="M14 27l7 7 17-17" stroke-dasharray="48"
                                stroke-dashoffset="48"></path>
                        </svg>
                    </div>

                    <h2 class="fw-bold mb-2" style="color:#111; font-size:1.75rem;">Thank You!</h2>

                    <p class="text-muted mb-4" style="font-size:1rem;">
                        Your order has been successfully placed. We are preparing it for you. You will receive an email
                        confirmation shortly.
                    </p>

                    <button type="button" class="btn btn-primary btn-lg rounded-pill px-5" data-bs-dismiss="modal"
                        style="font-weight:500; font-size:1rem;">
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tick Animation Styles -->
    <style>
        .tick-path {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: drawTick 0.6s 0.4s forwards ease-in-out;
        }

        @keyframes drawTick {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scaleTick {
            0% {
                transform: scale(0);
            }

            60% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

    <!-- Confetti + Livewire event wiring -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        window.addEventListener('show-thankyou', () => {
            var thankYouModal = new bootstrap.Modal(document.getElementById('orderConfirmationModal'));
            thankYouModal.show();
            thankYouModal._element.addEventListener('shown.bs.modal', function() {
                confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: {
                        y: 0.6
                    }
                });
            }, {
                once: true
            });
        });

        // small helper for notify events (optional)
        window.addEventListener('notify', (e) => {
            // you can wire this to your toast library; for now we'll use alert
            if (e.detail && e.detail.message) {
                alert(e.detail.message);
            }
        });
    </script>
