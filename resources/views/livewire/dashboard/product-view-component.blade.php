<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Header -->
            <div class="card card-body py-3 mb-4">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <div class="d-flex align-items-center gap-3">
                                <a href="{{ route('dev.product') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                                <h4 class="mb-4 mb-sm-0 card-title">Product Details</h4>
                            </div>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item d-flex align-items-center">
                                        <a class="text-muted text-decoration-none d-flex" href="{{ route('admin.dashboard') }}">
                                            <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dev.product') }}">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ Str::limit($product->name, 30) }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="product-image-wrapper">
                                <img src="{{ $product->media->first()?->file_path ?? asset('web/images/placeholder.jpg') }}" 
                                     alt="{{ $product->name }}"
                                     class="img-fluid rounded-3"
                                     style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @if($product->brand)
                                            <span class="badge bg-info">{{ $product->brand->name }}</span>
                                        @endif
                                        @foreach($product->categories as $category)
                                            <span class="badge bg-secondary">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                    <p class="text-muted mb-0">{{ Str::limit($product->description, 150) }}</p>
                                </div>
                                <div class="text-end">
                                    <div class="fs-4 fw-bold text-primary">Rs. {{ number_format($product->prices?->final_price ?? 0, 0) }}</div>
                                    <div class="text-muted">SKU: {{ $product->sku }}</div>
                                    <div class="text-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                        <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                        ({{ $product->stock }})
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs border-bottom px-4 pt-3" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link {{ $activeTab == 'overview' ? 'active' : '' }}" 
                                    wire:click="setActiveTab('overview')">
                                <i class="fa-solid fa-chart-simple me-1"></i> Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link {{ $activeTab == 'reviews' ? 'active' : '' }}" 
                                    wire:click="setActiveTab('reviews')">
                                <i class="fa-solid fa-star me-1"></i> Reviews
                                @if($stats['pending_reviews'] > 0)
                                    <span class="badge bg-danger ms-1">{{ $stats['pending_reviews'] }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link {{ $activeTab == 'sales' ? 'active' : '' }}" 
                                    wire:click="setActiveTab('sales')">
                                <i class="fa-solid fa-chart-line me-1"></i> Sales
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4">
                        <!-- Overview Tab -->
                        @if($activeTab == 'overview')
                            <div>
                                <!-- Stats Cards -->
                                <div class="row g-3 mb-4">
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="card bg-primary text-white border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <h6 class="text-white-50 mb-1">Total Revenue</h6>
                                                <h4 class="fw-bold mb-0">Rs. {{ number_format($stats['total_revenue'], 0) }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="card bg-success text-white border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <h6 class="text-white-50 mb-1">Total Sold</h6>
                                                <h4 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="card bg-warning text-white border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <h6 class="text-white-50 mb-1">Average Rating</h6>
                                                <h4 class="fw-bold mb-0">
                                                    {{ $stats['average_rating'] }} 
                                                    <i class="fa-solid fa-star text-white-50" style="font-size: 14px;"></i>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="card bg-info text-white border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <h6 class="text-white-50 mb-1">Total Reviews</h6>
                                                <h4 class="fw-bold mb-0">{{ $stats['total_reviews'] }}</h4>
                                                <small class="text-white-50">
                                                    {{ $stats['approved_reviews'] }} approved | {{ $stats['pending_reviews'] }} pending
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rating Distribution -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Rating Distribution</h6>
                                        @foreach($ratingDistribution as $stars => $count)
                                            @php
                                                $total = array_sum($ratingDistribution);
                                                $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                                            @endphp
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span style="min-width: 60px;">{{ $stars }} ★</span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" 
                                                         role="progressbar" 
                                                         style="width: {{ $percentage }}%"
                                                         aria-valuenow="{{ $percentage }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <span style="min-width: 40px;">{{ $count }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Top Customers</h6>
                                        @forelse($topCustomers as $customer)
                                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                <div>
                                                    <div class="fw-semibold">{{ $customer['customer_name'] }}</div>
                                                    <small class="text-muted">{{ $customer['customer_email'] }}</small>
                                                </div>
                                                <div class="text-end">
                                                    <div class="text-primary">Rs. {{ number_format($customer['total_spent'], 0) }}</div>
                                                    <small class="text-muted">{{ $customer['total_quantity'] }} items</small>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-3">No customers yet</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Reviews Tab -->
                        @if($activeTab == 'reviews')
                            <div>
                                <!-- Review Filters -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0">
                                                <i class="fa-solid fa-search"></i>
                                            </span>
                                            <input type="text" class="form-control border-0 bg-light" 
                                                   placeholder="Search reviews..."
                                                   wire:model.live="searchReview">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" wire:model.live="reviewFilter">
                                            <option value="all">All Reviews</option>
                                            <option value="approved">Approved</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5 text-end">
                                        <button class="btn btn-success" wire:click="exportReviews">
                                            <i class="fa-solid fa-download me-1"></i> Export
                                        </button>
                                    </div>
                                </div>

                                <!-- Reviews List -->
                                @forelse($reviews as $review)
                                    <div class="border rounded-3 p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <strong>{{ $review->user?->name ?? 'Anonymous' }}</strong>
                                                    <span class="text-muted">•</span>
                                                    <span class="text-muted">{{ $review->created_at->diffForHumans() }}</span>
                                                    @if($review->approved)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </div>
                                                <div class="text-warning mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                                <p class="mb-1">{{ $review->review }}</p>
                                                @if($review->reply)
                                                    <div class="bg-light p-2 rounded-3 mt-2">
                                                        <small class="text-muted">Reply from Admin:</small>
                                                        <p class="mb-0">{{ $review->reply }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex gap-1 flex-shrink-0">
                                                @if(!$review->approved)
                                                    <button class="btn btn-sm btn-success" wire:click="approveReview({{ $review->id }})" title="Approve">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-warning" wire:click="rejectReview({{ $review->id }})" title="Reject">
                                                        <i class="fa-solid fa-times"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-primary" wire:click="showReplyForm({{ $review->id }})" title="Reply">
                                                    <i class="fa-solid fa-reply"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" wire:click="deleteReview({{ $review->id }})" title="Delete" onclick="return confirm('Delete this review?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-comment-slash fa-3x mb-3 d-block"></i>
                                        <h6>No reviews found</h6>
                                    </div>
                                @endforelse

                                <div class="mt-3">
                                    {{ $reviews->links() }}
                                </div>
                            </div>
                        @endif

                        <!-- Sales Tab -->
                        @if($activeTab == 'sales')
                            <div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3">Sales Overview</h6>
                                                <canvas id="salesChart" height="250"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3">Recent Sales</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Quantity</th>
                                                                <th class="text-end">Revenue</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($salesData as $sale)
                                                                <tr>
                                                                    <td>{{ \Carbon\Carbon::parse($sale['date'])->format('M d, Y') }}</td>
                                                                    <td>{{ $sale['quantity'] }}</td>
                                                                    <td class="text-end text-primary">Rs. {{ number_format($sale['revenue'], 0) }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center text-muted">No sales data</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form wire:submit.prevent="saveReply">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">Reply to Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Your Reply</label>
                            <textarea class="form-control @error('reviewReply') is-invalid @enderror" 
                                      wire:model="reviewReply" 
                                      rows="4" 
                                      placeholder="Write your reply here..."></textarea>
                            @error('reviewReply') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Send Reply</span>
                            <span wire:loading>Sending...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('livewire:initialized', function () {
    // Show reply modal
    Livewire.on('show-reply-modal', () => {
        const modal = new bootstrap.Modal(document.getElementById('replyModal'));
        modal.show();
    });

    // Hide reply modal
    Livewire.on('hide-reply-modal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('replyModal'));
        if (modal) modal.hide();
    });

    // Initialize chart when sales tab is active
    Livewire.on('refreshProduct', function () {
        setTimeout(initSalesChart, 500);
    });
});

function initSalesChart() {
    const canvas = document.getElementById('salesChart');
    if (!canvas) return;

    const salesData = @json($salesData);
    if (salesData && salesData.length > 0) {
        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: salesData.map(item => item.date),
                datasets: [
                    {
                        label: 'Quantity Sold',
                        data: salesData.map(item => item.quantity),
                        backgroundColor: 'rgba(30, 64, 175, 0.7)',
                        borderColor: 'rgba(30, 64, 175, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                    },
                    {
                        label: 'Revenue (Rs.)',
                        data: salesData.map(item => item.revenue),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value;
                            }
                        }
                    }
                }
            }
        });
    }
}

// Initialize chart when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initSalesChart, 1000);
});
</script>
@endpush