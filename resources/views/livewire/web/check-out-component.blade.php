<div>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Checkout</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Checkout</li>
                            </ul>
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
                <div class="ec-checkout-leftside col-lg-8 col-md-12">
                    <div class="checkout-steps p-4 bg-white border rounded-4">
                        <!-- Step Tabs -->
                        <ul class="nav nav-tabs mb-4" id="checkoutTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'shipping' ? 'active' : '' }}"
                                    wire:click="tabShow('shipping')">
                                    <i class="fa-solid fa-truck me-1"></i> Shipping
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'payment' ? 'active' : '' }} {{ !session('activeAddress') ? 'disabled' : '' }}"
                                    wire:click="{{ session('activeAddress') ? 'tabShow(\'payment\')' : '' }}"
                                    {{ !session('activeAddress') ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-credit-card me-1"></i> Payment
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'review' ? 'active' : '' }} {{ !(session('activeAddress')) ? 'disabled' : '' }}"
                                    wire:click="{{ session('activeAddress') ? 'tabShow(\'review\')' : '' }}"
                                    {{ !session('activeAddress') ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-check-circle me-1"></i> Review
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="checkoutTabsContent">
                            <!-- Shipping Tab -->
                            @if($activeTab == 'shipping')
                                <div class="tab-pane fade show active">
                                    @livewire('web.components.address-manager')
                                </div>
                            @endif

                            <!-- Payment Tab -->
                            @if($activeTab == 'payment')
                                <div class="tab-pane fade show active">
                                    <h4 class="fw-bold mb-3">Select Payment Method</h4>
                                    
                                    <div class="payment-method-selected">
                                        <div class="alert alert-info p-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <i class="fa-solid fa-hand-holding-dollar fa-2x"></i>
                                                <div>
                                                    <h5 class="fw-bold mb-1">Cash on Delivery</h5>
                                                    <p class="mb-0">Pay when your order arrives at your doorstep.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" wire:model="payment_method" value="cod">
                                    
                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn btn-outline-primary px-4" wire:click="tabShow('shipping')">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Back
                                        </button>
                                        <button class="btn btn-primary px-5" wire:click="goToReview">
                                            Review Order <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Review Tab -->
                            @if($activeTab == 'review')
                                <div class="tab-pane fade show active" id="review">
                                    <h5 class="fw-bold mb-3">Review & Confirm</h5>

                                    <div class="border rounded-3 p-4 mb-4">
                                        <h6 class="fw-bold mb-2">Shipping Address</h6>
                                        @if ($address)
                                            <p class="mb-1"><strong>{{ $address->name }}</strong></p>
                                            <p class="mb-1">{{ $address->phone }}</p>
                                            <p class="mb-1">{{ $address->full_address }}</p>
                                        @else
                                            <p class="text-danger">No shipping address selected</p>
                                        @endif
                                    </div>

                                    <div class="border rounded-3 p-4 mb-4">
                                        <h6 class="fw-bold mb-2">Payment Method</h6>
                                        <p class="mb-0"><strong>Cash on Delivery</strong></p>
                                    </div>

                                    <div class="border rounded-3 p-4 mb-4">
                                        <h6 class="fw-bold mb-2">Order Summary</h6>
                                        <div class="d-flex justify-content-between py-1">
                                            <span>Sub-Total</span>
                                            <span>Rs. {{ number_format($subtotal, 0) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-1">
                                            <span>Shipping</span>
                                            <span>Rs. {{ number_format($shippingCost, 0) }}</span>
                                        </div>
                                        @if (session('applied_coupon.discount'))
                                            <div class="d-flex justify-content-between py-1 text-success">
                                                <span>Discount</span>
                                                <span>- Rs. {{ number_format(session('applied_coupon.discount'), 0) }}</span>
                                            </div>
                                        @endif
                                        <div class="d-flex justify-content-between py-2 border-top mt-2">
                                            <span class="fw-bold">Total</span>
                                            <span class="fw-bold text-primary fs-5">Rs. {{ number_format($total, 0) }}</span>
                                        </div>
                                    </div>

                                    <!-- Order Items -->
                                    <div class="border rounded-3 p-4 mb-4">
                                        <h6 class="fw-bold mb-2">Items ({{ count($cart) }})</h6>
                                        @foreach ($cart as $item)
                                            <div class="d-flex justify-content-between py-2 border-bottom">
                                                <div>
                                                    <strong>{{ $item['name'] }}</strong>
                                                    @if ($item['variant_options'])
                                                        <div class="text-muted small">{{ $item['variant_options'] }}</div>
                                                    @endif
                                                    <div class="text-muted small">Qty: {{ $item['qty'] }}</div>
                                                </div>
                                                <div class="fw-bold">Rs. {{ number_format($item['price'] * $item['qty'], 0) }}</div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-center mt-4">
                                        <button class="btn btn-success px-5 py-3 fw-bold" 
                                                wire:click="placeOrder"
                                                wire:loading.attr="disabled"
                                                @if($placing) disabled @endif>
                                            <i class="fa-solid fa-lock me-2"></i>
                                            <span wire:loading.remove>Place Order Securely</span>
                                            <span wire:loading>Placing...</span>
                                        </button>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                🔒 100% Secure Checkout • 💳 SSL Encrypted • 🛡️ Money-Back Guarantee
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mt-3">
                                        <button class="btn btn-outline-secondary btn-sm" wire:click="tabShow('payment')">
                                            <i class="fa-solid fa-arrow-left me-1"></i> Back to Payment
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Area Start -->
                <div class="ec-checkout-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Order Summary</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-summary mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Sub-Total</span>
                                        <span>Rs. {{ number_format($subtotal, 0) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Delivery Charges</span>
                                        <span>Rs. {{ number_format($shippingCost, 0) }}</span>
                                    </div>

                                    @livewire('web.components.cart-coupon-component')

                                    <div class="ec-checkout-summary-total mt-3 pt-2 border-top d-flex justify-content-between">
                                        <span><strong>Total Amount</strong></span>
                                        <span><strong class="text-primary">Rs. {{ number_format($total, 0) }}</strong></span>
                                    </div>
                                </div>

                                <div class="ec-checkout-pro">
                                    @forelse ($cart as $item)
                                        @php
                                            $img = $item['image'] ?? null;
                                            $name = $item['name'] ?? 'Unknown product';
                                            $price = $item['price'] ?? 0;
                                        @endphp
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div style="width:60px; height:60px; overflow:hidden; border-radius:8px; flex-shrink:0;">
                                                <img src="{{ $img ?? asset('web/images/placeholder.jpg') }}"
                                                    style="width:100%;height:100%;object-fit:cover;"
                                                    alt="{{ $name }}">
                                            </div>
                                            <div style="flex:1;">
                                                <h6 class="mb-0">{{ Str::limit($name, 30) }}</h6>
                                                <small class="text-muted">Qty. {{ $item['qty'] }}</small>
                                            </div>
                                            <div class="fw-bold">Rs. {{ number_format($price * $item['qty'], 0) }}</div>
                                        </div>
                                    @empty
                                        <p class="text-muted text-center">No items in cart.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Thank You Modal -->
    <div class="modal fade" id="orderConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-body text-center p-5">
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
                    <p class="text-muted mb-4">Your order has been successfully placed. You will receive an email confirmation shortly.</p>

                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tick-path {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: drawTick 0.6s 0.4s forwards ease-in-out;
        }

        @keyframes drawTick {
            to { stroke-dashoffset: 0; }
        }

        @keyframes scaleTick {
            0% { transform: scale(0); }
            60% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .nav-tabs .nav-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        window.addEventListener('show-thankyou', () => {
            var thankYouModal = new bootstrap.Modal(document.getElementById('orderConfirmationModal'));
            thankYouModal.show();
            thankYouModal._element.addEventListener('shown.bs.modal', function() {
                confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.6 }
                });
            }, { once: true });
        });
    </script>
</div>