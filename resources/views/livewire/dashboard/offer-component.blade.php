<div class="body-wrapper">
    <div class="container-fluid">
    <div class="card card-body py-3 mb-3">
        <div class="d-flex align-items-center">
            <h4 class="mb-0">Offers</h4>
            <div class="ms-auto d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search offers..."
                       wire:model.debounce.500ms="search" style="max-width:220px;">
                <button wire:click="create" class="btn btn-primary btn-sm">Create Offer</button>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success d-flex align-items-center justify-content-between">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Validity</th>
                            <th>Coupons</th>
                            <th>Status</th>
                            <th style="width:120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($offers as $offer)
                            <tr>
                                <td>
                                    <strong>{{ $offer->title }}</strong>
                                    @if($offer->description)
                                        <div><small class="text-muted">{{ \Str::limit($offer->description, 90) }}</small></div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark text-capitalize">{{ str_replace('_', ' ', $offer->type) }}</span>
                                </td>
                                <td>
                                    @if($offer->discount_type === 'percentage')
                                        <span class="fw-semibold">{{ (float) rtrim(rtrim($offer->discount_value + 0, '0'), '.') }}%</span>
                                    @elseif($offer->discount_type === 'free_shipping')
                                        <span class="text-success fw-semibold">Free shipping</span>
                                    @else
                                        <span class="fw-semibold">{{ number_format($offer->discount_value, 2) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        <div><span class="text-muted">Start:</span> {{ $offer->start_date ? $offer->start_date->format('d M, Y') : '—' }}</div>
                                        <div><span class="text-muted">End:</span> {{ $offer->end_date ? $offer->end_date->format('d M, Y') : '—' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $offer->coupons_count }}</span>
                                    <a href="{{ route('dev-coupons') }}" class="btn btn-sm btn-outline-secondary ms-2">Manage</a>
                                </td>
                                <td>
                                    <button type="button" wire:click="toggle({{ $offer->id }})"
                                            class="badge border-0 {{ $offer->status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $offer->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" wire:click="edit({{ $offer->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button type="button" wire:click="delete({{ $offer->id }})" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <div class="fw-semibold mb-2">No offers created yet</div>
                                        <div>Create your first promotional offer to drive sales.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $offers->links() }}
            </div>
        </div>
    </div>

    {{-- Offer Modal --}}
    <div id="offerModal" class="modal fade" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="max-height: 90vh;">
            <form wire:submit.prevent="{{ $offerId ? 'update' : 'store' }}">
                
                <!-- Modal Header -->
                <div class="modal-header sticky-top bg-white" style="z-index:1050;">
                    <h5 class="modal-title">{{ $offerId ? 'Edit Offer' : 'Create Offer' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="modal-body" style="overflow-y: auto; max-height: 65vh;">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model.defer="title">
                        @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" wire:model.live="type">
                                <option value="product">Product</option>
                                <option value="category">Category</option>
                                <option value="cart">Cart</option>
                                <option value="shipping">Shipping</option>
                                <option value="user">User</option>
                                <option value="order">Order</option>
                            </select>
                            @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Type</label>
                            <select class="form-select" wire:model.defer="discount_type">
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed</option>
                                <option value="bogo">BOGO</option>
                                <option value="free_shipping">Free Shipping</option>
                            </select>
                            @error('discount_type') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    @if(in_array($type, ['product','category']))
                        <div class="mb-3">
                            <label class="form-label">Select {{ ucfirst($type) }}</label>

                            <div x-data="{
                                search: '',
                                selected: @entangle('applies_to').defer,
                                options: @js($options),
                                get filtered() {
                                    const term = (this.search || '').toLowerCase();
                                    if (!term) return this.options;
                                    return this.options.filter(option => option.label.toLowerCase().includes(term));
                                },
                                toggle(optionValue) {
                                    const value = Number(optionValue);
                                    if (!Array.isArray(this.selected)) {
                                        this.selected = [];
                                    }
                                    if (this.selected.includes(value)) {
                                        this.selected = this.selected.filter(item => item !== value);
                                    } else {
                                        this.selected = [...this.selected, value];
                                    }
                                }
                            }" class="border rounded p-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="small text-muted">Choose one or more {{ strtolower($type) }}s</div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="selected = []; search = ''">Clear</button>
                                </div>

                                <input type="text" class="form-control form-control-sm mb-2" x-model="search" placeholder="Search {{ strtolower($type) }}s...">

                                <div class="border rounded bg-white" style="max-height: 220px; overflow: auto;">
                                    <template x-for="option in filtered" :key="option.value">
                                        <label class="d-flex align-items-center gap-2 px-3 py-2 border-bottom" style="cursor:pointer;">
                                            <input type="checkbox" class="form-check-input" :checked="selected.includes(Number(option.value))" @change="toggle(option.value)">
                                            <span x-text="option.label"></span>
                                        </label>
                                    </template>

                                    <template x-if="filtered.length === 0">
                                        <div class="px-3 py-2 text-muted small">No matches found</div>
                                    </template>
                                </div>

                                <div class="mt-2 small text-muted" x-text="Array.isArray(selected) && selected.length ? `${selected.length} selected` : 'No selection yet'"></div>

                                <div class="mt-2">
                                    <template x-for="option in options.filter(option => Array.isArray(selected) && selected.includes(Number(option.value)))" :key="option.value">
                                        <span class="badge bg-primary me-1 mb-1" x-text="option.label"></span>
                                    </template>
                                </div>
                            </div>
                            @error('applies_to') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Value</label>
                            <input type="number" step="0.01" class="form-control" wire:model.defer="discount_value">
                            @error('discount_value') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Min Cart Amount</label>
                            <input type="number" step="0.01" class="form-control" wire:model.defer="min_cart_amount">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Max Discount</label>
                            <input type="number" step="0.01" class="form-control" wire:model.defer="max_discount">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shared Code (optional)</label>
                        <input type="text" class="form-control" wire:model.defer="code">
                        <small class="text-muted">Optional: a shared coupon code (e.g. SAVE10).</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Usage Limit</label>
                            <input type="number" class="form-control" wire:model.defer="usage_limit">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Per User Limit</label>
                            <input type="number" class="form-control" wire:model.defer="per_user_limit">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stackable</label>
                            <select class="form-select" wire:model.defer="stackable">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" class="form-control" wire:model.defer="start_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" class="form-control" wire:model.defer="end_date">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (optional)</label>
                        <textarea class="form-control" rows="3" wire:model.defer="description"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer sticky-bottom bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @if($offerId)
                        <button type="submit" class="btn btn-primary">Update Offer</button>
                    @else
                        <button type="submit" class="btn btn-success">Create Offer</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

</div>
    {{-- Modal show/hide listeners --}}
    <script>
        window.addEventListener('show-offer-modal', () => {
            const modalEl = document.getElementById('offerModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });
        window.addEventListener('hide-offer-modal', () => {
            const el = document.getElementById('offerModal');
            const modal = bootstrap.Modal.getInstance(el);
            if (modal) modal.hide();
        });
    </script>
</div>
