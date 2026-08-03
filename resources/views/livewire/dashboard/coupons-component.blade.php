<div class="body-wrapper">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Coupon Management</h3>
                <p class="text-muted mb-0">Create, edit, and monitor store discounts from one place.</p>
            </div>
            <button class="btn btn-primary" wire:click="create" wire:loading.attr="disabled">
                <iconify-icon icon="solar:add-circle-bold-duotone" class="me-1"></iconify-icon>
                Add Coupon
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3 border-0 mb-4">{{ session('success') }}</div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-2">Total Coupons</p>
                        <h4 class="fw-bold mb-0">{{ $coupons->total() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-2">Active</p>
                        <h4 class="fw-bold mb-0 text-success">{{ $coupons->getCollection()->where('status', true)->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-2">Inactive</p>
                        <h4 class="fw-bold mb-0 text-secondary">{{ $coupons->getCollection()->where('status', false)->count() }}</h4>
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
                                <th class="text-muted">#</th>
                                <th class="text-muted">Code</th>
                                <th class="text-muted">Offer</th>
                                <th class="text-muted">Type</th>
                                <th class="text-muted">Value</th>
                                <th class="text-muted">Status</th>
                                <th class="text-muted text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td><span class="fw-semibold">{{ $coupon->code }}</span></td>
                                    <td>{{ optional($coupon->offer)->title ?? '—' }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $coupon->discount_type)) }}</td>
                                    <td>
                                        @if ($coupon->discount_type === 'percentage')
                                            {{ $coupon->discount_value }}%
                                        @else
                                            {{ number_format($coupon->discount_value, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $coupon->status ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                            {{ $coupon->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $coupon->id }})">
                                            <iconify-icon icon="solar:pen-2-line-duotone"></iconify-icon>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" wire:click="delete({{ $coupon->id }})">
                                            <iconify-icon icon="solar:trash-bin-trash-line-duotone"></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">No coupons found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>

        <div id="coupon-modal" class="modal fade" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0">
                    <form wire:submit.prevent="{{ $couponId ? 'update' : 'store' }}">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $couponId ? 'Edit Coupon' : 'Create Coupon' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" wire:model.defer="code" placeholder="Auto-generated if empty">
                                @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attach to Offer</label>
                                <select wire:model.defer="offer_id" class="form-select">
                                    <option value="">-- None --</option>
                                    @foreach ($offers as $offer)
                                        <option value="{{ $offer->id }}">{{ $offer->title }}</option>
                                    @endforeach
                                </select>
                                @error('offer_id')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Discount Type</label>
                                    <select wire:model.defer="discount_type" class="form-select">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="free_shipping">Free Shipping</option>
                                    </select>
                                    @error('discount_type')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Discount Value</label>
                                    <input type="number" step="0.01" class="form-control" wire:model.defer="discount_value">
                                    @error('discount_value')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label">Usage Limit</label>
                                    <input type="number" class="form-control" wire:model.defer="usage_limit">
                                    @error('usage_limit')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Per User Limit</label>
                                    <input type="number" class="form-control" wire:model.defer="per_user_limit">
                                    @error('per_user_limit')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="datetime-local" class="form-control" wire:model.defer="start_date" id="start_date">
                                    @error('start_date')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">End Date</label>
                                    <input type="datetime-local" class="form-control" wire:model.defer="end_date" id="end_date">
                                    @error('end_date')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" wire:model.defer="status" id="couponStatus">
                                <label class="form-check-label" for="couponStatus">Active</label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">{{ $couponId ? 'Update' : 'Create' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('show-coupon-modal', () => {
            const modalEl = document.getElementById('coupon-modal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });
        window.addEventListener('hide-coupon-modal', () => {
            const modalEl = document.getElementById('coupon-modal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    </script>
</div>
