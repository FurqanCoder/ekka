<div class="body-wrapper">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Order Details</h3>
                <p class="text-muted mb-0">Invoice {{ $order->invoice_no }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-primary">Download Invoice</a>
                <a href="{{ route('admin.orders.packingSlip', $order->id) }}" class="btn btn-outline-primary">Packing Slip</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3 border-0 mb-4">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title fw-semibold mb-0">Customer Information</h5>
                            <span class="badge bg-primary-subtle text-primary">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <p class="text-muted small mb-1">Name</p>
                                <p class="fw-semibold mb-0">{{ $order->customer_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted small mb-1">Phone</p>
                                <p class="fw-semibold mb-0">{{ $order->customer_phone }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted small mb-1">Email</p>
                                <p class="fw-semibold mb-0">{{ $order->customer_email ?: '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Shipping Information</h5>
                        <p class="mb-1 fw-semibold">{{ $order->shipping_address }}</p>
                        <p class="text-muted mb-0">
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_postal_code }}
                        </p>
                        <div class="mt-3">
                            <span class="text-muted small">Method:</span>
                            <span class="fw-semibold ms-2">{{ $order->shipping_method_name ?: 'Standard' }}</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Order Items</h5>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-muted">Product</th>
                                        <th class="text-muted">Variant</th>
                                        <th class="text-muted">Price</th>
                                        <th class="text-muted">Qty</th>
                                        <th class="text-muted">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td class="text-muted">{{ $item->variant_id ? optional($item->variant)->variant_name : '—' }}</td>
                                            <td>Rs {{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td class="fw-semibold">Rs {{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Order Summary</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between"><span>Subtotal</span><strong>Rs {{ number_format($order->subtotal, 2) }}</strong></li>
                            <li class="list-group-item px-0 d-flex justify-content-between"><span>Discount</span><strong>Rs {{ number_format($order->discount_amount ?? 0, 2) }}</strong></li>
                            <li class="list-group-item px-0 d-flex justify-content-between"><span>Shipping</span><strong>Rs {{ number_format($order->shipping_charges, 2) }}</strong></li>
                            @if ($order->coupon_code)
                                <li class="list-group-item px-0 d-flex justify-content-between"><span>Coupon</span><strong class="text-success">{{ $order->coupon_code }}</strong></li>
                            @endif
                            <li class="list-group-item px-0 pt-3 d-flex justify-content-between"><span class="fw-bold">Grand Total</span><span class="fw-bold">Rs {{ number_format($order->grand_total, 2) }}</span></li>
                        </ul>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Payment Details</h5>
                        <p class="mb-2"><span class="text-muted me-2">Method:</span><strong>{{ strtoupper($order->payment_method) }}</strong></p>
                        <p class="mb-0"><span class="text-muted me-2">Status:</span>
                            @if ($order->payment_status === 'paid')
                                <span class="badge bg-success-subtle text-success">Paid</span>
                            @elseif ($order->payment_status === 'failed')
                                <span class="badge bg-danger-subtle text-danger">Failed</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Update Status</h5>
                        <select wire:model="status" class="form-select mb-3">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <button wire:click="updateStatus" class="btn btn-primary w-100">Update Status</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h5 class="fw-semibold mb-4">Order Timeline</h5>
                @php
                    $steps = [
                        'pending' => ['label' => 'Pending', 'date' => $order->created_at],
                        'confirmed' => ['label' => 'Confirmed', 'date' => $order->confirmed_at],
                        'shipped' => ['label' => 'Shipped', 'date' => $order->shipped_at],
                        'delivered' => ['label' => 'Delivered', 'date' => $order->delivered_at],
                    ];
                    $current = $order->status;
                @endphp
                <div class="row g-3">
                    @foreach ($steps as $key => $step)
                        @php
                            $isCompleted = !empty($step['date']) && $key !== $current;
                            $isActive = $key === $current;
                        @endphp
                        <div class="col-md-3">
                            <div class="border rounded-3 p-3 h-100 {{ $isActive ? 'border-primary bg-primary-subtle' : ($isCompleted ? 'border-success bg-success-subtle' : 'border-light') }}">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="rounded-circle {{ $isActive ? 'bg-primary text-white' : ($isCompleted ? 'bg-success text-white' : 'bg-light text-muted') }} d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        {{ $loop->iteration }}
                                    </span>
                                    <strong>{{ $step['label'] }}</strong>
                                </div>
                                <div class="small text-muted">{{ $step['date'] ? $step['date']->format('d M, Y h:i A') : 'Pending' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
