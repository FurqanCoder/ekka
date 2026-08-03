<div class="body-wrapper">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Orders Overview</h3>
                <p class="text-muted mb-0">Track new orders, manage fulfillment, and keep payments on schedule.</p>
            </div>
            <div class="badge bg-primary-subtle text-primary px-3 py-2">{{ $stats['total'] }} orders</div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="small text-muted mb-1">Total</p>
                        <h5 class="fw-bold mb-0">{{ $stats['total'] }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="small text-muted mb-1">Pending</p>
                        <h5 class="fw-bold mb-0 text-warning">{{ $stats['pending'] }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="small text-muted mb-1">Processing</p>
                        <h5 class="fw-bold mb-0 text-primary">{{ $stats['processing'] }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="small text-muted mb-1">Shipped</p>
                        <h5 class="fw-bold mb-0 text-info">{{ $stats['shipped'] }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="small text-muted mb-1">Delivered</p>
                        <h5 class="fw-bold mb-0 text-success">{{ $stats['delivered'] }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="small text-muted mb-1">Revenue</p>
                        <h5 class="fw-bold mb-0">Rs {{ number_format($stats['revenue'], 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Invoice, name, phone...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Order Status</label>
                        <select wire:model.live="status" class="form-select">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Payment Status</label>
                        <select wire:model.live="paymentStatus" class="form-select">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-muted">Invoice</th>
                                <th class="text-muted">Customer</th>
                                <th class="text-muted">Payment</th>
                                <th class="text-muted">Status</th>
                                <th class="text-muted">Total</th>
                                <th class="text-muted">Date</th>
                                <th class="text-muted text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="fw-semibold">{{ $order->invoice_no }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $order->customer_name }}</div>
                                        <div class="small text-muted">{{ $order->customer_phone }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ strtoupper($order->payment_method) }}</div>
                                        @if ($order->payment_status === 'paid')
                                            <span class="badge bg-success-subtle text-success">Paid</span>
                                        @elseif ($order->payment_status === 'failed')
                                            <span class="badge bg-danger-subtle text-danger">Failed</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $color = match ($order->status) {
                                                'pending' => 'bg-warning-subtle text-warning',
                                                'confirmed' => 'bg-info-subtle text-info',
                                                'processing' => 'bg-primary-subtle text-primary',
                                                'shipped' => 'bg-purple-subtle text-purple',
                                                'delivered' => 'bg-success-subtle text-success',
                                                'cancelled' => 'bg-danger-subtle text-danger',
                                                default => 'bg-secondary-subtle text-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $color }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="fw-semibold">Rs {{ number_format($order->grand_total, 2) }}</td>
                                    <td class="text-muted">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('dev-order.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
