<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Header -->
            <div class="card card-body py-3 mb-4">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Reports & Analytics</h4>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item d-flex align-items-center">
                                        <a class="text-muted text-decoration-none d-flex"
                                            href="{{ route('admin.dashboard') }}">
                                            <iconify-icon icon="solar:home-2-line-duotone"
                                                class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                            Reports
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Report Type</label>
                            <select class="form-select" wire:model.live="reportType">
                                <option value="sales">Sales Report</option>
                                <option value="orders">Orders Report</option>
                                <option value="products">Products Report</option>
                                <option value="customers">Customers Report</option>
                                <option value="categories">Categories Report</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Date Range</label>
                            <select class="form-select" wire:model.live="dateRange">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="this_week">This Week</option>
                                <option value="last_week">Last Week</option>
                                <option value="this_month" selected>This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="this_year">This Year</option>
                                <option value="last_year">Last Year</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">From</label>
                            <input type="date" class="form-control" wire:model="startDate">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">To</label>
                            <input type="date" class="form-control" wire:model="endDate">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" wire:click="loadReports">
                                <i class="fa-solid fa-refresh me-2"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                @if ($reportType === 'sales')
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Total Revenue</h6>
                                <h3 class="fw-bold mb-0">Rs. {{ number_format($summary['total_revenue'] ?? 0, 0) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Total Orders</h6>
                                <h3 class="fw-bold mb-0">{{ $summary['total_orders'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-info text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Average Order Value</h6>
                                <h3 class="fw-bold mb-0">Rs.
                                    {{ number_format($summary['average_order_value'] ?? 0, 0) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-warning text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Best Day</h6>
                                <h5 class="fw-bold mb-0">{{ $summary['best_day'] ?? 'N/A' }}</h5>
                            </div>
                        </div>
                    </div>
                @elseif($reportType === 'orders')
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1">Total Orders</p>
                                <h4 class="fw-bold mb-0">{{ $summary['total_orders'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1">Pending</p>
                                <h4 class="fw-bold mb-0 text-warning">{{ $summary['pending_orders'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1">Delivered</p>
                                <h4 class="fw-bold mb-0 text-success">{{ $summary['delivered_orders'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1">Cancelled</p>
                                <h4 class="fw-bold mb-0 text-danger">{{ $summary['cancelled_orders'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1">Returned</p>
                                <h4 class="fw-bold mb-0 text-secondary">{{ $summary['returned_orders'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                @elseif($reportType === 'products')
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Total Products</h6>
                                <h3 class="fw-bold mb-0">{{ $summary['total_products'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Total Sold</h6>
                                <h3 class="fw-bold mb-0">{{ $summary['total_sold'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-info text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Total Revenue</h6>
                                <h3 class="fw-bold mb-0">Rs. {{ number_format($summary['total_revenue'] ?? 0, 0) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-warning text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Top Selling</h6>
                                <h5 class="fw-bold mb-0">{{ Str::limit($summary['top_selling'] ?? 'N/A', 20) }}</h5>
                            </div>
                        </div>
                    </div>
                @elseif($reportType === 'customers')
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Total Customers</h6>
                                <h3 class="fw-bold mb-0">{{ $summary['total_customers'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">New Customers</h6>
                                <h3 class="fw-bold mb-0">{{ $summary['new_customers'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-info text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Repeat Customers</h6>
                                <h3 class="fw-bold mb-0">{{ $summary['repeat_customers'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-warning text-white shadow-lg border-0 rounded-4">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 mb-1">Avg. Spent</h6>
                                <h3 class="fw-bold mb-0">Rs. {{ number_format($summary['average_spent'] ?? 0, 0) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Charts & Tables -->
            <div class="row g-3">
                @if ($reportType === 'sales' || $reportType === 'orders')
                    <!-- Sales Chart -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div
                                class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                                <h5 class="card-title fw-bold mb-0">
                                    {{ $reportType === 'sales' ? 'Sales Trend' : 'Order Timeline' }}
                                </h5>
                                <button class="btn btn-sm btn-outline-primary" wire:click="exportReport('chart')">
                                    <i class="fa-solid fa-download me-1"></i> Export
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <canvas id="salesChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Status Breakdown -->
                    <!-- Status Chart - Only show if orderData exists -->
                    @if ($reportType === 'orders' && !empty($orderData))
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0 p-4">
                                    <h5 class="card-title fw-bold mb-0">Order Status</h5>
                                </div>
                                <div class="card-body p-4">
                                    <canvas id="statusChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Sales Chart - Only show if salesData exists -->
                    @if (($reportType === 'sales' || $reportType === 'orders') && !empty($salesData))
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div
                                    class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                                    <h5 class="card-title fw-bold mb-0">
                                        {{ $reportType === 'sales' ? 'Sales Trend' : 'Order Timeline' }}
                                    </h5>
                                    <button class="btn btn-sm btn-outline-primary" wire:click="exportReport('chart')">
                                        <i class="fa-solid fa-download me-1"></i> Export
                                    </button>
                                </div>
                                <div class="card-body p-4">
                                    <canvas id="salesChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif

                @endif

                <!-- Data Tables -->
                @if ($reportType === 'products')
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div
                                class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                                <h5 class="card-title fw-bold mb-0">Top Products</h5>
                                <button class="btn btn-sm btn-outline-primary" wire:click="exportReport('products')">
                                    <i class="fa-solid fa-download me-1"></i> Export
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">#</th>
                                                <th>Product</th>
                                                <th>SKU</th>
                                                <th>Total Sold</th>
                                                <th>Total Orders</th>
                                                <th>Stock</th>
                                                <th class="pe-4">Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($productData as $index => $product)
                                                <tr>
                                                    <td class="ps-4">{{ $index + 1 }}</td>
                                                    <td>{{ Str::limit($product['name'], 30) }}</td>
                                                    <td>{{ $product['sku'] }}</td>
                                                    <td>{{ $product['total_sold'] }}</td>
                                                    <td>{{ $product['total_orders'] }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $product['stock'] > 10 ? 'success' : 'danger' }}">
                                                            {{ $product['stock'] }}
                                                        </span>
                                                    </td>
                                                    <td class="pe-4 fw-bold text-primary">
                                                        Rs. {{ number_format($product['total_revenue'], 0) }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-4 text-muted">
                                                        <i class="fa-solid fa-box fa-2x mb-2 d-block"></i>
                                                        No products sold in this period
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($reportType === 'customers')
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div
                                class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                                <h5 class="card-title fw-bold mb-0">Top Customers</h5>
                                <button class="btn btn-sm btn-outline-primary" wire:click="exportReport('customers')">
                                    <i class="fa-solid fa-download me-1"></i> Export
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">#</th>
                                                <th>Customer</th>
                                                <th>Email</th>
                                                <th>Total Orders</th>
                                                <th>Last Order</th>
                                                <th class="pe-4">Total Spent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($customerData as $index => $customer)
                                                <tr>
                                                    <td class="ps-4">{{ $index + 1 }}</td>
                                                    <td>{{ $customer['name'] }}</td>
                                                    <td>{{ $customer['email'] }}</td>
                                                    <td>{{ $customer['total_orders'] }}</td>
                                                    <td>{{ $customer['last_order'] }}</td>
                                                    <td class="pe-4 fw-bold text-primary">
                                                        Rs. {{ number_format($customer['total_spent'], 0) }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        <i class="fa-solid fa-users fa-2x mb-2 d-block"></i>
                                                        No customer data available
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($reportType === 'categories')
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div
                                class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                                <h5 class="card-title fw-bold mb-0">Category Performance</h5>
                                <button class="btn btn-sm btn-outline-primary"
                                    wire:click="exportReport('categories')">
                                    <i class="fa-solid fa-download me-1"></i> Export
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">#</th>
                                                <th>Category</th>
                                                <th>Total Sold</th>
                                                <th class="pe-4">Total Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($categoryData as $index => $category)
                                                <tr>
                                                    <td class="ps-4">{{ $index + 1 }}</td>
                                                    <td>{{ $category['name'] }}</td>
                                                    <td>{{ $category['total_sold'] }}</td>
                                                    <td class="pe-4 fw-bold text-primary">
                                                        Rs. {{ number_format($category['total_revenue'], 0) }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">
                                                        <i class="fa-solid fa-tags fa-2x mb-2 d-block"></i>
                                                        No category data available
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', function() {
            // Listen for report updates
            Livewire.on('refreshReports', function() {
                setTimeout(initCharts, 500);
            });
        });

        function initCharts() {
            // Sales Chart
            const salesCanvas = document.getElementById('salesChart');
            if (salesCanvas) {
                const salesData = @json($salesData);
                if (salesData && salesData.length > 0) {
                    new Chart(salesCanvas, {
                        type: 'line',
                        data: {
                            labels: salesData.map(item => item.date),
                            datasets: [{
                                    label: 'Revenue (Rs.)',
                                    data: salesData.map(item => item.total || item.revenue || 0),
                                    borderColor: '#1e40af',
                                    backgroundColor: 'rgba(30, 64, 175, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                },
                                {
                                    label: 'Orders',
                                    data: salesData.map(item => item.orders || 0),
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                    yAxisID: 'y1',
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
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
                                },
                                y1: {
                                    position: 'right',
                                    beginAtZero: true,
                                    grid: {
                                        drawOnChartArea: false,
                                    },
                                    ticks: {
                                        stepSize: 1,
                                    }
                                }
                            }
                        }
                    });
                }
            }

            // Status Chart
            const statusCanvas = document.getElementById('statusChart');
            if (statusCanvas) {
                const orderData = @json($orderData);
                if (orderData && orderData.length > 0) {
                    const colors = {
                        'Pending': '#ffc107',
                        'Confirmed': '#0dcaf0',
                        'Processing': '#0d6efd',
                        'Shipped': '#0dcaf0',
                        'Delivered': '#10b981',
                        'Cancelled': '#ef4444',
                        'Returned': '#6c757d',
                    };

                    new Chart(statusCanvas, {
                        type: 'doughnut',
                        data: {
                            labels: orderData.map(item => item.status),
                            datasets: [{
                                data: orderData.map(item => item.count),
                                backgroundColor: orderData.map(item =>
                                    colors[item.status] || '#6c757d'
                                ),
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
                                        padding: 15,
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
        }

        // Initialize charts on page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initCharts, 1000);
        });
    </script>
@endpush
