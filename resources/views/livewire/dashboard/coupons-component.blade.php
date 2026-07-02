<div class="body-wrapper">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">🎟 Coupons Management</h4>
            <button class="btn btn-primary" wire:click="create">
                <i class="bi bi-plus-lg"></i> Add Coupon
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Offer</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td><span class="fw-bold">{{ $coupon->code }}</span></td>
                                <td>{{ optional($coupon->offer)->title ?? '-' }}</td>
                                <td>{{ ucfirst($coupon->discount_type) }}</td>
                                <td>
                                    @if ($coupon->discount_type === 'percentage')
                                        {{ $coupon->discount_value }}%
                                    @else
                                        {{ number_format($coupon->discount_value, 2) }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $coupon->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $coupon->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        wire:click="edit({{ $coupon->id }})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:click="delete({{ $coupon->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No coupons found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>

        {{-- Coupon Modal --}}
        <div id="coupon-modal" class="modal fade" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="max-height: 90vh;">
                    <form wire:submit.prevent="{{ $couponId ? 'update' : 'store' }}">

                        <!-- Modal Header -->
                        <div class="modal-header sticky-top bg-white" style="z-index:1050;">
                            <h5 class="modal-title">{{ $couponId ? 'Edit Coupon' : 'Create Coupon' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body (Scrollable) -->
                        <div class="modal-body" style="overflow-y: auto; max-height: 65vh;">

                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" wire:model.defer="code"
                                    placeholder="AUTO-GENERATED if empty">
                                @error('code')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attach to Offer (Optional)</label>
                                <select wire:model.defer="offer_id" class="form-select">
                                    <option value="">-- None --</option>
                                    @foreach ($offers as $offer)
                                        <option value="{{ $offer->id }}">{{ $offer->title }}</option>
                                    @endforeach
                                </select>
                                @error('offer_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Discount Type</label>
                                    <select wire:model.defer="discount_type" class="form-select">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="free_shipping">Free Shipping</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Discount Value</label>
                                    <input type="number" step="0.01" class="form-control"
                                        wire:model.defer="discount_value">
                                    @error('discount_value')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Usage Limit</label>
                                    <input type="number" class="form-control" wire:model.defer="usage_limit">
                                    @error('usage_limit')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Per User Limit</label>
                                    <input type="number" class="form-control" wire:model.defer="per_user_limit">
                                    @error('per_user_limit')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="datetime-local" class="form-control" wire:model.defer="start_date"
                                        min="{{ now()->format('Y-m-d\TH:i') }}" id="start_date">
                                    @error('start_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="datetime-local" class="form-control" wire:model.defer="end_date"
                                        id="end_date" min="{{ now()->format('Y-m-d\TH:i') }}">
                                    @error('end_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const startInput = document.getElementById('start_date');
                                    const endInput = document.getElementById('end_date');

                                    // Disable past date/time
                                    const now = new Date();
                                    const localISOTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                                        .toISOString().slice(0, 16);
                                    startInput.min = localISOTime;
                                    endInput.min = localISOTime;

                                    // When start date changes, update end date min
                                    startInput.addEventListener('change', function() {
                                        endInput.min = startInput.value;
                                        if (endInput.value < startInput.value) {
                                            endInput.value = startInput.value;
                                        }
                                    });
                                });
                            </script>


                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" wire:model.defer="status"
                                    id="couponStatus">
                                <label class="form-check-label" for="couponStatus">Active</label>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer sticky-bottom bg-white">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit"
                                class="btn btn-primary">{{ $couponId ? 'Update' : 'Create' }}</button>
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
            const el = document.getElementById('coupon-modal');
            const modal = bootstrap.Modal.getInstance(el);
            if (modal) modal.hide();
        });
    </script>
</div>
