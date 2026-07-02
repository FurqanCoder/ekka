<div class="body-wrapper">
    <h4 class="mb-3">Manage Discounts</h4>

    {{-- Flash --}}
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#discountModal">+ Add Discount</a>

    {{-- Discounts Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Value</th>
                <th>Code</th>
                <th>Usage</th>
                <th>Active</th>
                <th>Product</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($discounts as $d)
                <tr>
                    <td>{{ $d->title }}</td>
                    <td>{{ ucfirst($d->type) }}</td>
                    <td>{{ $d->value }}</td>
                    <td>{{ $d->code ?? '-' }}</td>
                    <td>{{ $d->used_count }}/{{ $d->usage_limit ?? '∞' }}</td>
                    <td>{{ $d->active ? 'Yes' : 'No' }}</td>
                    <td>{{ $d->product->name ?? '-' }}</td>
                    <td>{{ $d->category->name ?? '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" wire:click="edit({{ $d->id }})"
                            data-bs-toggle="modal" data-bs-target="#discountModal">Edit</button>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $d->id }})"
                            onclick="return confirm('Delete this discount?')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No discounts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $discounts->links() }}

    {{-- Modal --}}
    <div wire:ignore.self class="modal fade" id="discountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $discountId ? 'Edit Discount' : 'Add Discount' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            {{-- Title --}}
                            <div class="col-md-6">
                                <label>Title</label>
                                <input type="text" wire:model="title" class="form-control">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div class="col-md-6">
                                <label>Type</label>
                                <select wire:model="type" class="form-control">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                    <option value="buy_one_get_one">Buy 1 Get 1</option>
                                </select>
                            </div>

                            {{-- Value --}}
                            <div class="col-md-6">
                                <label>Value</label>
                                <input type="number" step="0.01" wire:model="value" class="form-control">
                            </div>

                            {{-- Code --}}
                            <div class="col-md-6">
                                <label>Coupon Code</label>
                                <div class="input-group">
                                    <input type="text" wire:model="code" class="form-control">
                                    <button type="button" class="btn btn-outline-secondary"
                                        wire:click="generateCode">Generate</button>
                                </div>
                            </div>

                            {{-- Usage Limit --}}
                            <div class="col-md-6">
                                <label>Usage Limit</label>
                                <input type="number" wire:model="usage_limit" class="form-control"
                                    placeholder="Leave empty for unlimited">
                            </div>

                            {{-- Start Date --}}
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input type="date" wire:model="start_date" class="form-control">
                            </div>

                            {{-- End Date --}}
                            <div class="col-md-6">
                                <label>End Date</label>
                                <input type="date" wire:model="end_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Scope</label>
                                <select wire:model="scope" class="form-control">
                                    <option value="product">Product</option>
                                    <option value="category">Category</option>
                                    <option value="cart">Cart</option>
                                    <option value="global">Global</option>
                                </select>
                            </div>

                            <div wire:if="$scope === 'product'">
                                <label>Products (multi)</label>
                                <select wire:model="product_ids" multiple class="form-control">
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div wire:if="$scope === 'cart'">
                                <label>Min Cart Amount</label>
                                <input type="number" step="0.01" wire:model="min_cart_amount" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Usage Limit</label>
                                <input type="number" wire:model="usage_limit" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Per User Limit</label>
                                <input type="number" wire:model="usage_limit_per_user" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Combinable</label>
                                <input type="checkbox" wire:model="combinable">
                            </div>

                            <div class="col-md-3">
                                <label>Priority</label>
                                <input type="number" wire:model="priority" class="form-control" min="0">
                            </div>

                            {{-- Product --}}
                            <div class="col-md-6">
                                <label>Product</label>
                                <select wire:model="product_id" class="form-control">
                                    <option value="">-- None --</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label>Category</label>
                                <select wire:model="category_id" class="form-control">
                                    <option value="">-- None --</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Active --}}
                            <div class="col-md-12">
                                <label>
                                    <input type="checkbox" wire:model="active"> Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            {{ $discountId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
