<!-- resources/views/livewire/web/dashboard/dashboard-overview.blade.php -->
<div>
    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-primary bg-gradient text-white rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Orders</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h3>
                    </div>
                    <i class="fa-solid fa-box fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-warning bg-gradient text-white rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Pending Orders</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['pending_orders'] }}</h3>
                    </div>
                    <i class="fa-solid fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-success bg-gradient text-white rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Spent</h6>
                        <h3 class="fw-bold mb-0">Rs. {{ number_format($stats['total_spent'], 0) }}</h3>
                    </div>
                    <i class="fa-solid fa-wallet fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-danger bg-gradient text-white rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Wishlist</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['wishlist_count'] }}</h3>
                    </div>
                    <i class="fa-solid fa-heart fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Recent Orders</h5>
            <a href="#" wire:click="$parent.setActiveTab('orders')" class="text-primary text-decoration-none">
                View All <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        @if(count($recentOrders) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td class="fw-bold">#{{ $order['invoice_no'] }}</td>
                                <td>{{ $order['created_at'] }}</td>
                                <td>{{ $order['items_count'] }}</td>
                                <td>Rs. {{ number_format($order['grand_total'], 0) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order['status_badge'] }} rounded-pill px-3 py-2">
                                        {{ ucfirst($order['status']) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('order.detail', $order['invoice_no']) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fa-solid fa-box fa-3x text-muted mb-3"></i>
                <h6 class="text-muted">No orders yet</h6>
                <a href="" class="btn btn-primary btn-sm">Start Shopping</a>
            </div>
        @endif
    </div>

    <style>
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: default;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
    </style>
</div>