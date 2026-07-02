<div>
    <style>
        <style>.order-timeline {
            position: relative;
            padding: 20px 10px;
        }

        .order-step {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .order-step .circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background: #f5f5f5;
            transition: 0.4s ease;
        }

        /* ACTIVE Step */
        .order-step.active .circle {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
            transform: scale(1.1);
        }

        /* COMPLETED Step */
        .order-step.completed .circle {
            background: #28a745;
            border-color: #28a745;
            color: #fff;
            position: relative;
        }

        .order-step.completed .circle::after {
            content: "✓";
            position: absolute;
            font-size: 20px;
            font-weight: 700;
            animation: tickPop 0.5s ease forwards;
        }

        /* Checkmark Animation */
        @keyframes tickPop {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Horizontal Line */
        .timeline-line {
            position: absolute;
            top: 32px;
            left: 8%;
            right: 8%;
            height: 2px;
            background: #d1d5db;
            z-index: 1;
        }
    </style>

    </style>
    <div class="body-wrapper">
        <div class="container-fluid">

            <!-- PAGE HEADER -->
            <div class="card card-body py-3 mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="card-title mb-0">
                            Order Details — {{ $order->invoice_no }}
                        </h4>
                    </div>

                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-primary me-2">Download Invoice</a>
                        <a href="{{ route('admin.orders.packingSlip', $order->id) }}" class="btn btn-outline-primary">Packing Slip</a>
                    </div>
                </div>
            </div>

            <!-- SUCCESS MESSAGE -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- GRID LAYOUT -->
            <div class="row g-4">

                <!-- LEFT SECTION -->
                <div class="col-lg-8">

                    <!-- CUSTOMER INFO -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Customer Information</h5>

                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <p class="text-muted mb-1">Name</p>
                                    <p class="fw-semibold">{{ $order->customer_name }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p class="text-muted mb-1">Phone</p>
                                    <p class="fw-semibold">{{ $order->customer_phone }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p class="text-muted mb-1">Email</p>
                                    <p class="fw-semibold">{{ $order->customer_email ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SHIPPING ADDRESS -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Shipping Address</h5>

                            <p class="mb-0">{{ $order->shipping_address }}</p>
                            <p class="text-muted">
                                {{ $order->shipping_city }},
                                {{ $order->shipping_state }}
                                - {{ $order->shipping_postal_code }}
                            </p>
                        </div>
                    </div>

                    <!-- ORDER ITEMS -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Order Items</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->product_name }}</td>

                                                <td class="text-muted">
                                                    @if ($item->variant_id)
                                                        {{ $item->variant->variant_name }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>Rs {{ number_format($item->price) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td class="fw-semibold">
                                                    Rs {{ number_format($item->total) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- RIGHT SECTION -->
                <div class="col-lg-4">

                    <!-- ORDER SUMMARY -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Order Summary</h5>

                            <ul class="list-group list-group-flush">

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <strong>Rs {{ number_format($order->subtotal) }}</strong>
                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Discount</span>
                                    <strong>Rs {{ number_format($order->discount) }}</strong>
                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Shipping Charges</span>
                                    <strong>Rs {{ number_format($order->shipping_charges) }}</strong>
                                </li>

                                @if ($order->coupon_code)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Coupon</span>
                                        <strong class="text-success">{{ $order->coupon_code }}</strong>
                                    </li>
                                @endif

                                <li class="list-group-item d-flex justify-content-between border-0 pt-3">
                                    <span class="fw-bold fs-5">Grand Total</span>
                                    <span class="fw-bold fs-5">Rs {{ number_format($order->grand_total) }}</span>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <!-- PAYMENT DETAILS -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Payment Details</h5>

                            <p class="mb-1">
                                <span class="text-muted">Method:</span>
                                <strong>{{ strtoupper($order->payment_method) }}</strong>
                            </p>

                            <p class="mb-0">
                                <span class="text-muted">Status:</span>

                                @if ($order->payment_status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif ($order->payment_status === 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- STATUS UPDATE -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Update Status</h5>

                            <select wire:model="status" class="form-select mb-3">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>

                            <button wire:click="updateStatus" class="btn btn-primary w-100">
                                Update Status
                            </button>

                        </div>
                    </div>

                </div>

            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <h5 class="mb-4 fw-bold">Order Status Timeline</h5>

                    @php
                        $steps = [
                            'pending' => ['label' => 'Pending', 'date' => $order->created_at],
                            'confirmed' => ['label' => 'Confirmed', 'date' => $order->confirmed_at],
                            'shipped' => ['label' => 'Shipped', 'date' => $order->shipped_at],
                            'delivered' => ['label' => 'Delivered', 'date' => $order->delivered_at],
                        ];

                        $current = $order->status;
                    @endphp

                    <div class="order-timeline d-flex justify-content-between">
                        <div class="timeline-line"></div>

                        @foreach ($steps as $key => $step)
                            @php
                                $isCompleted = $step['date'] && $key !== $current;
                                $isActive = $key === $current;
                            @endphp

                            <div
                                class="order-step {{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
                                <div class="circle">
                                    @if (!$isCompleted)
                                        {{ $loop->iteration }}
                                    @endif
                                </div>

                                <div class="fw-semibold mt-2">{{ $step['label'] }}</div>
                                <div class="text-muted small">
                                    {{ $step['date'] ? $step['date']->format('d M, Y h:i A') : '—' }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>



</div>
