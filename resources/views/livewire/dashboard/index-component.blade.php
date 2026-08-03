<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Stats Cards -->
            <!-- Stats Cards -->
<div class="row g-3 mb-3">
    <!-- Revenue Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Revenue</h6>
                        <h3 class="fw-bold mb-0">Rs. {{ number_format($stats['total_revenue'] ?? 0, 0) }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <i class="fa-solid fa-wallet fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-50">
                        <i class="fa-solid fa-arrow-up me-1"></i>
                        Today: Rs. {{ number_format($stats['today_revenue'] ?? 0, 0) }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Orders Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card bg-success text-white shadow-lg border-0 rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Orders</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total_orders'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <i class="fa-solid fa-shopping-bag fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-50">
                        <i class="fa-solid fa-clock me-1"></i>
                        Today: {{ $stats['today_orders'] ?? 0 }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card bg-warning text-white shadow-lg border-0 rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Customers</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total_customers'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-50">
                        <i class="fa-solid fa-user-plus me-1"></i>
                        Active customers
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card bg-danger text-white shadow-lg border-0 rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Products</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total_products'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <i class="fa-solid fa-box fa-2x"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-white-50">
                        <i class="fa-solid fa-tag me-1"></i>
                        {{ $stats['total_categories'] ?? 0 }} categories
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Cards -->
<div class="row g-3 mb-3">
    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pending</p>
                        <h4 class="fw-bold mb-0">{{ $stats['pending_orders'] ?? 0 }}</h4>
                    </div>
                    <div class="bg-warning-subtle rounded-3 p-3">
                        <i class="fa-solid fa-clock text-warning fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Confirmed</p>
                        <h4 class="fw-bold mb-0">{{ $stats['confirmed_orders'] ?? 0 }}</h4>
                    </div>
                    <div class="bg-info-subtle rounded-3 p-3">
                        <i class="fa-solid fa-check text-info fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Processing</p>
                        <h4 class="fw-bold mb-0">{{ $stats['processing_orders'] ?? 0 }}</h4>
                    </div>
                    <div class="bg-primary-subtle rounded-3 p-3">
                        <i class="fa-solid fa-spinner text-primary fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Shipped</p>
                        <h4 class="fw-bold mb-0">{{ $stats['shipped_orders'] ?? 0 }}</h4>
                    </div>
                    <div class="bg-info-subtle rounded-3 p-3">
                        <i class="fa-solid fa-truck text-info fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Delivered</p>
                        <h4 class="fw-bold mb-0">{{ $stats['delivered_orders'] ?? 0 }}</h4>
                    </div>
                    <div class="bg-success-subtle rounded-3 p-3">
                        <i class="fa-solid fa-check-circle text-success fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Cancelled</p>
                        <h4 class="fw-bold mb-0">{{ $stats['cancelled_orders'] ?? 0 }}</h4>
                    </div>
                    <div class="bg-danger-subtle rounded-3 p-3">
                        <i class="fa-solid fa-xmark-circle text-danger fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

          

            <!-- Recent Orders & Top Products -->
            <div class="row g-3 mb-3">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                            <h5 class="card-title fw-bold mb-0">Recent Orders</h5>
                            <a href="{{ route('dev-order.lists') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Order #</th>
                                            <th>Customer</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th class="pe-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                            <tr>
                                                <td class="ps-4 fw-bold">#{{ $order['invoice_no'] }}</td>
                                                <td>
                                                    <div>
                                                        <div class="fw-semibold">{{ $order['customer_name'] }}</div>
                                                        <small class="text-muted">{{ $order['customer_email'] }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ $order['items_count'] }}</td>
                                                <td class="fw-bold text-primary">Rs. {{ number_format($order['grand_total'], 0) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order['status_badge'] }} rounded-pill px-3">
                                                        {{ ucfirst($order['status']) }}
                                                    </span>
                                                </td>
                                                <td>{{ $order['created_at'] }}</td>
                                                <td class="pe-4">
                                                    <a href="{{ route('dev-order.show', $order['id']) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    <i class="fa-solid fa-box fa-2x mb-2 d-block"></i>
                                                    No orders found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                            <h5 class="card-title fw-bold mb-0">Top Products</h5>
                            <a href="{{ route('dev.product') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body p-3">
                            @forelse($topProducts as $product)
                                <div class="d-flex align-items-center gap-3 p-2 border-bottom">
                                    <img src="{{ $product['image'] }}" 
                                         alt="{{ $product['name'] }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-semibold">{{ Str::limit($product['name'], 25) }}</h6>
                                        <div class="d-flex gap-3">
                                            <small class="text-muted">Sold: {{ $product['total_sold'] }}</small>
                                            <small class="text-muted">Stock: {{ $product['stock'] }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold text-primary">Rs. {{ number_format($product['price'], 0) }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-box fa-2x mb-2 d-block"></i>
                                    No products found
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue & Customers -->
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                            <h5 class="card-title fw-bold mb-0">Monthly Revenue</h5>
                            <span class="text-muted">This Year</span>
                        </div>
                        <div class="card-body p-4">
                            @if(count($monthlyRevenue) > 0)
                                <canvas id="monthlyRevenueChart" height="200"></canvas>
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-chart-line fa-2x mb-2 d-block"></i>
                                    No revenue data available
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="card-title fw-bold mb-0">Order Status</h5>
                        </div>
                        <div class="card-body p-4">
                            @if(count($orderStatusCounts) > 0)
                                <canvas id="orderStatusChart" height="200"></canvas>
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-chart-pie fa-2x mb-2 d-block"></i>
                                    No data available
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Revenue Chart
    const revenueData = @json($monthlyRevenue);
    if (revenueData.length > 0) {
        const ctx = document.getElementById('monthlyRevenueChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: revenueData.map(item => item.month),
                    datasets: [{
                        label: 'Revenue',
                        data: revenueData.map(item => item.total),
                        backgroundColor: 'rgba(26, 26, 46, 0.7)',
                        borderColor: 'rgba(26, 26, 46, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rs. ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // Order Status Chart
    const statusData = @json($orderStatusCounts);
    if (statusData) {
        const ctx = document.getElementById('orderStatusChart');
        if (ctx) {
            const labels = Object.keys(statusData).map(key => key.charAt(0).toUpperCase() + key.slice(1));
            const values = Object.values(statusData);
            const colors = {
                pending: '#ffc107',
                processing: '#0dcaf0',
                shipped: '#0d6efd',
                delivered: '#198754',
                completed: '#198754',
                cancelled: '#dc3545'
            };
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: labels.map(label => {
                            const key = label.toLowerCase();
                            return colors[key] || '#6c757d';
                        }),
                        borderWidth: 2,
                        borderColor: '#ffffff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    }
});
</script>
@endpush