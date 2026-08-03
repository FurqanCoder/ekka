<!-- resources/views/livewire/web/dashboard/user-addresses.blade.php -->
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">My Addresses</h5>
        <button class="btn btn-primary btn-sm" wire:click="showCreate">
            <i class="fa-solid fa-plus me-1"></i> Add New Address
        </button>
    </div>

    <!-- Address Form -->
    @if($showForm)
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">{{ $editingId ? 'Edit Address' : 'Add New Address' }}</h6>
                
                <form wire:submit.prevent="save">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   wire:model="name" placeholder="John Doe">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   wire:model="phone" placeholder="+92 300 1234567">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address Label</label>
                            <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                   wire:model="label" placeholder="Home, Office, etc.">
                            @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                   wire:model="country" placeholder="Pakistan">
                            @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Province/State</label>
                            <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                   wire:model="province" placeholder="Punjab">
                            @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   wire:model="city" placeholder="Lahore">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Postal Code</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                   wire:model="postal_code" placeholder="54000">
                            @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address Line 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" 
                                   wire:model="address_line_1" placeholder="House #, Street, Area">
                            @error('address_line_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Address Line 2</label>
                            <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" 
                                   wire:model="address_line_2" placeholder="Landmark, Building, etc.">
                            @error('address_line_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_default" wire:model="is_default">
                                <label class="form-check-label fw-semibold" for="is_default">
                                    Set as default address
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa-solid fa-save me-1"></i> {{ $editingId ? 'Update' : 'Save' }} Address
                                </button>
                                <button type="button" class="btn btn-secondary px-4" wire:click="resetForm">
                                    <i class="fa-solid fa-times me-1"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Addresses List -->
    @if($addresses->count() > 0)
        <div class="row g-3">
            @foreach($addresses as $address)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">
                                        {{ $address->label ?? 'Address' }}
                                        @if($address->is_default)
                                            <span class="badge bg-success ms-2">Default</span>
                                        @endif
                                    </h6>
                                    <p class="mb-1"><strong>{{ $address->name }}</strong></p>
                                    <p class="mb-1 text-muted small">{{ $address->address_line_1 }}</p>
                                    @if($address->address_line_2)
                                        <p class="mb-1 text-muted small">{{ $address->address_line_2 }}</p>
                                    @endif
                                    <p class="mb-1 text-muted small">{{ $address->city }}, {{ $address->province }}</p>
                                    <p class="mb-1 text-muted small">{{ $address->country }} - {{ $address->postal_code }}</p>
                                    <p class="mb-0 text-muted small"><i class="fa-solid fa-phone me-1"></i> {{ $address->phone }}</p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#" wire:click.prevent="edit({{ $address->id }})">
                                                <i class="fa-solid fa-pen me-2"></i> Edit
                                            </a>
                                        </li>
                                        @if(!$address->is_default)
                                            <li>
                                                <a class="dropdown-item" href="#" wire:click.prevent="setDefault({{ $address->id }})">
                                                    <i class="fa-solid fa-check-circle me-2"></i> Set as Default
                                                </a>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" 
                                               wire:click.prevent="deleteAddress({{ $address->id }})"
                                               onclick="return confirm('Are you sure you want to delete this address?')">
                                                <i class="fa-solid fa-trash me-2"></i> Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fa-solid fa-location-dot fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">No addresses saved yet</h6>
            <p class="text-muted small">Add your shipping addresses for faster checkout</p>
            <button class="btn btn-primary btn-sm" wire:click="showCreate">
                <i class="fa-solid fa-plus me-1"></i> Add Address
            </button>
        </div>
    @endif
</div>