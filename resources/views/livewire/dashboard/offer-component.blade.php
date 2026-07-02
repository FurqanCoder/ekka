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
        <div class="alert alert-success">{{ session('success') }}</div>
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
                                <td>{{ ucfirst($offer->type) }}</td>
                                <td>
                                    @if($offer->discount_type === 'percentage')
                                        {{ (float) rtrim(rtrim($offer->discount_value + 0, '0'), '.') }}%
                                    @elseif($offer->discount_type === 'free_shipping')
                                        Free shipping
                                    @else
                                        {{ number_format($offer->discount_value, 2) }}
                                    @endif
                                </td>
                                <td>
                                    @if($offer->start_date) {{ $offer->start_date->format('d M, Y') }} @else — @endif
                                     -
                                    @if($offer->end_date) {{ $offer->end_date->format('d M, Y') }} @else — @endif
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $offer->coupons_count }}</span>
                                    <a href="" class="btn btn-sm btn-outline-secondary ms-2">Manage</a>
                                </td>
                                <td>
                                    <span wire:click="toggle({{ $offer->id }})" style="cursor:pointer"
                                          class="badge {{ $offer->status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $offer->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button wire:click="edit({{ $offer->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button wire:click="delete({{ $offer->id }})" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">No offers found</td></tr>
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
                            <select class="form-select" wire:model="type">
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
                                open: false,
                                search: '',
                                selected: @entangle('applies_to').defer,
                                options: @js($options),

                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },

                                toggle(v) {
                                    if(this.selected.includes(v)) {
                                        this.selected = this.selected.filter(x => x !== v);
                                    } else {
                                        this.selected.push(v);
                                    }
                                }
                            }" class="position-relative">
                                <div class="form-control d-flex justify-content-between" 
                                     @click="open = !open" style="cursor:pointer">
                                    <div>
                                        <template x-if="selected.length">
                                            <span x-text="options.filter(o => selected.includes(o.value)).map(o => o.label).join(', ')"></span>
                                        </template>
                                        <template x-if="!selected.length">
                                            <span class="text-muted">Click to select...</span>
                                        </template>
                                    </div>
                                    <i class="bi bi-chevron-down"></i>
                                </div>

                                <div x-show="open" x-transition 
                                     @click.outside="open = false" 
                                     class="border bg-white position-absolute w-100 p-2"
                                     style="z-index:1000; max-height:280px; overflow:auto;">
                                    <div class="d-flex mb-2">
                                        <input x-model="search" class="form-control form-control-sm me-2" placeholder="Search...">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" @click="selected = []; search = ''">Clear</button>
                                    </div>
                                    <template x-for="opt in filtered" :key="opt.value">
                                        <div class="form-check p-1" @click="toggle(opt.value)" style="cursor:pointer">
                                            <input class="form-check-input" type="checkbox" :checked="selected.includes(opt.value)">
                                            <label class="form-check-label" x-text="opt.label"></label>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-2">
                                    <template x-for="opt in options.filter(o => applies_to.includes(o.value))" :key="opt.value">
                                        <span class="badge bg-primary me-1" x-text="opt.label"></span>
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
