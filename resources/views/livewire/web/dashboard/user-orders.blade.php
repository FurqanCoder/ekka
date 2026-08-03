<!-- resources/views/livewire/web/dashboard/user-orders.blade.php -->
<div>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h5 class="fw-bold mb-0">My Orders</h5>
        <div>
            <span class="text-muted">Total: {{ $orders->total() }} orders</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="row g-2 mb-4">
        <div class="col-md-4">
            <select class="form-select" wire:model.live="statusFilter">
                <option value="all">All Orders</option>
                @foreach($statuses as $status)
                    @if($status !== 'all')
                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Search by Order #" wire:model.live="search">
        </div>
        <div class="col-md-4">
            <select class="form-select" wire:model.live="perPage">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
            </select>
        </div>
    </div>

    <!-- Loading State -->
    <div wire:loading class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="fw-bold">#{{ $order->invoice_no }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td class="fw-bold text-primary">Rs. {{ number_format($order->grand_total, 0) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $this->getStatusBadge($order->status) }} rounded-pill px-3 py-2">
                                <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('order.detail', $order->invoice_no) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if(in_array($order->status, ['pending', 'processing']))
                                    <button class="btn btn-sm btn-outline-danger" 
                                            wire:click="cancelOrder({{ $order->id }})" 
                                            onclick="return confirm('Are you sure you want to cancel this order?')">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fa-solid fa-box fa-3x text-muted mb-3 d-block"></i>
                            <h6 class="text-muted">No orders found</h6>
                            <a href="" class="btn btn-primary btn-sm mt-2">Continue Shopping</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>