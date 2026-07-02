<div>
<div class="body-wrapper">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="card card-body py-3 mb-4">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-0 card-title">Orders Overview</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex" href="#">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">Orders</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="card w-100 position-relative overflow-hidden mb-4">
            <div class="px-4 py-3 border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-0">Order Filters</h4>
            </div>

            <div class="card-body p-4 row g-3">

                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" wire:model.live="search" class="form-control"
                           placeholder="Search invoice, name, phone...">
                </div>

                <!-- Order Status -->
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

                <!-- Payment Status -->
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

        <!-- Orders Table -->
        <div class="card w-100 position-relative overflow-hidden">
            <div class="px-4 py-3 border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-0">Orders Table</h4>
            </div>

            <div class="card-body p-4">

                <div class="table-responsive mb-4 border rounded-1">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th><h6 class="fs-4 fw-semibold mb-0">Invoice</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Customer</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Payment</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Order Status</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Total</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Date</h6></th>
                                <th class="text-end"><h6 class="fs-4 fw-semibold mb-0">Actions</h6></th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($orders as $order)
                                <tr>
                                    <!-- Invoice -->
                                    <td class="fw-semibold text-dark">
                                        {{ $order->invoice_no }}
                                    </td>

                                    <!-- Customer -->
                                    <td>
                                        <div class="fw-semibold">{{ $order->customer_name }}</div>
                                        <div class="text-muted small">{{ $order->customer_phone }}</div>
                                    </td>

                                    <!-- Payment -->
                                    <td>
                                        <span class="fw-semibold">{{ strtoupper($order->payment_method) }}</span><br>

                                        @if ($order->payment_status === 'paid')
                                            <span class="badge bg-success-subtle text-success">Paid</span>
                                        @elseif ($order->payment_status === 'failed')
                                            <span class="badge bg-danger-subtle text-danger">Failed</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @endif
                                    </td>

                                    <!-- Order Status -->
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

                                    <!-- Total -->
                                    <td class="fw-semibold text-dark">
                                        Rs {{ number_format($order->grand_total) }}
                                    </td>

                                    <!-- Date -->
                                    <td class="text-muted">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end">
                                        <a href="{{ route('dev-order.show', $order->id) }}" class="btn btn-primary btn-sm px-3">View</a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        No orders found.
                                    </td>
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

</div>
