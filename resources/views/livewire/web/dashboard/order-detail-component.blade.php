<!-- resources/views/livewire/web/dashboard/order-detail-component.blade.php -->
<div class="container py-4">
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <!-- Back Button -->
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
            </a>

            <div class="card border-0 shadow-sm rounded-4">
                <!-- Header -->
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h4 class="fw-bold mb-0">Order #{{ $order->invoice_no }}</h4>
                            <small class="text-muted">Placed on {{ $order->created_at->format('F d, Y h:i A') }}</small>
                        </div>
                        <span class="badge bg-{{ $this->getStatusBadge($order->status) }} rounded-pill px-4 py-2">
                            <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item->product_image ?? asset('web/images/placeholder.jpg') }}" 
                                                     alt="{{ $item->product_name }}"
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product_name }}</h6>
                                                    @if($item->variant_options)
                                                        <small class="text-muted">{{ $item->variant_options }}</small>
                                                    @endif
                                                    @if($item->product_sku)
                                                        <small class="text-muted d-block">SKU: {{ $item->product_sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rs. {{ number_format($item->price, 0) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-bold">Rs. {{ number_format($item->total, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="bg-light p-3 rounded-3">
                                <div class="d-flex justify-content-between py-1">
                                    <span>Subtotal</span>
                                    <span>Rs. {{ number_format($order->subtotal, 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1">
                                    <span>Shipping</span>
                                    <span>Rs. {{ number_format($order->shipping_charges, 0) }}</span>
                                </div>
                                @if($order->discount_amount > 0)
                                    <div class="d-flex justify-content-between py-1 text-success">
                                        <span>Discount</span>
                                        <span>- Rs. {{ number_format($order->discount_amount, 0) }}</span>
                                    </div>
                                @endif
                                @if($order->coupon_code)
                                    <div class="d-flex justify-content-between py-1">
                                        <span>Coupon</span>
                                        <span>{{ $order->coupon_code }}</span>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between py-2 border-top mt-2">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold text-primary fs-5">Rs. {{ number_format($order->grand_total, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping & Payment -->
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Shipping Address</h6>
                            <div class="bg-light p-3 rounded-3">
                                <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                                <p class="mb-0"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                                @if($order->customer_email)
                                    <p class="mb-0"><strong>Email:</strong> {{ $order->customer_email }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Payment Information</h6>
                            <div class="bg-light p-3 rounded-3">
                                <p class="mb-1"><strong>Method:</strong> {{ $this->getPaymentMethodLabel($order->payment_method) }}</p>
                                <p class="mb-0"><strong>Status:</strong> 
                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                                @if($order->transaction_id)
                                    <p class="mb-0"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Timeline (Optional) -->
                    @if($order->shipped_at || $order->delivered_at)
                        <div class="mt-4">
                            <h6 class="fw-bold mb-2">Order Timeline</h6>
                            <div class="bg-light p-3 rounded-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Order Placed</strong>
                                        <p class="mb-0 text-muted small">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    @if($order->confirmed_at)
                                        <div class="text-center">
                                            <i class="fa-solid fa-check-circle text-success"></i>
                                            <div>
                                                <strong>Confirmed</strong>
                                                <p class="mb-0 text-muted small">{{ $order->confirmed_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->shipped_at)
                                        <div class="text-center">
                                            <i class="fa-solid fa-truck text-primary"></i>
                                            <div>
                                                <strong>Shipped</strong>
                                                <p class="mb-0 text-muted small">{{ $order->shipped_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->delivered_at)
                                        <div class="text-center">
                                            <i class="fa-solid fa-check-circle text-success"></i>
                                            <div>
                                                <strong>Delivered</strong>
                                                <p class="mb-0 text-muted small">{{ $order->delivered_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-white border-0 py-4">
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fa-solid fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                        @if(in_array($order->status, ['pending', 'processing']))
                            <button class="btn btn-danger rounded-pill px-4" 
                                    wire:click="cancelOrder" 
                                    onclick="return confirm('Are you sure you want to cancel this order?')"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fa-solid fa-xmark me-2"></i> Cancel Order
                                </span>
                                <span wire:loading>
                                    <i class="fa-solid fa-spinner fa-spin me-2"></i> Cancelling...
                                </span>
                            </button>
                        @endif
                        @if($order->status === 'cancelled')
                            <div class="alert alert-danger mb-0">
                                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                This order has been cancelled.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>