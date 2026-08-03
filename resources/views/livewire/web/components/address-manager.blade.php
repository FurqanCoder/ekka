<div>
    <style>
        .address-option {
            flex: 1;
            min-width: 0;
        }

        .address-option input {
            display: none;
        }

        .address-option label {
            border: 1px solid #ddd;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            background: #fff;
            user-select: none;
        }

        .address-option input:checked+label {
            border-color: #0D6EFD;
            background: #0D6EFD;
            color: #FFF7EF;
            font-weight: bold;
        }

        .address-option i {
            font-size: 22px;
        }

        .address-options-wrapper {
            display: flex;
            gap: 12px;
            width: 100%;
            flex-wrap: nowrap;
        }
        
        .address-card {
            transition: all 0.3s ease;
        }
        
        .address-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .address-card.selected {
            border-color: #2563EB !important;
            background: #EFF6FF !important;
            box-shadow: 0 8px 20px rgba(37,99,235,0.12) !important;
        }
    </style>

    <div class="tab-pane fade show active" id="shipping" role="tabpanel">
        @if ($addresses->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-lg font-semibold">Saved Addresses</h3>
                <button wire:click="showCreate" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus me-1"></i> Add Address
                </button>
            </div>
            
            <div class="row g-3 mb-3">
                @forelse($addresses as $addr)
                    <div class="col-12">
                        <div class="address-card border rounded-3 p-3 {{ $selectedAddressId === $addr->id ? 'selected' : '' }}"
                             wire:click="selectAddress({{ $addr->id }})"
                             style="cursor: pointer; transition: all 0.3s ease;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <strong>{{ $addr->label ?? 'Address' }}</strong>
                                        @if ($addr->is_default)
                                            <span class="badge bg-success">Default</span>
                                        @endif
                                        @if ($selectedAddressId === $addr->id)
                                            <span class="badge bg-primary">Selected</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small">{{ $addr->full_address }}</div>
                                    <div class="text-muted small">{{ $addr->name }} — {{ $addr->phone }}</div>
                                </div>
                                <div class="d-flex gap-2 ms-2">
                                    @if (!$addr->is_default)
                                        <button wire:click.stop="setDefault({{ $addr->id }})" 
                                                class="btn btn-sm btn-outline-secondary">
                                            Set Default
                                        </button>
                                    @endif
                                    <button wire:click.stop="edit({{ $addr->id }})" 
                                            class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button wire:click.stop="deleteAddress({{ $addr->id }})" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this address?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No addresses available.</p>
                @endforelse
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-primary px-4" wire:click="gotoPayment">
                    Proceed to Payment <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>
            </div>
            <hr>
        @endif

        <h5 class="mb-3">Add New Shipping Address</h5>
        <div class="address-options-wrapper mb-3">
            <div class="address-option">
                <input type="radio" wire:model.defer="label" id="home" name="address_type" value="home" checked>
                <label for="home">
                    <span class="label-icon" style="font-size: large">🏠</span>
                    Home
                </label>
            </div>
            <div class="address-option">
                <input type="radio" id="office" wire:model.defer="label" name="address_type" value="office">
                <label for="office">
                    <span class="label-icon" style="font-size: large">🏢</span>
                    Office
                </label>
            </div>
            <div class="address-option">
                <input type="radio" id="other" wire:model.defer="label" name="address_type" value="other">
                <label for="other">
                    <span class="label-icon" style="font-size: large">✨</span>
                    Other
                </label>
            </div>
        </div>
        
        <form id="shippingForm" wire:submit.prevent="save">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" wire:model.defer="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="John Doe">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" wire:model.defer="phone" class="form-control @error('phone') is-invalid @enderror"
                        placeholder="0300 1234567">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Province/State</label>
                    <select wire:model.defer="province" class="form-control">
                        <option value="">Select Province</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Sindh">Sindh</option>
                        <option value="KPK">KPK</option>
                        <option value="Balochistan">Balochistan</option>
                        <option value="Gilgit-Baltistan">Gilgit-Baltistan</option>
                        <option value="Azad Kashmir">Azad Kashmir</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text" wire:model.defer="city" class="form-control @error('city') is-invalid @enderror"
                        placeholder="City Name">
                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Postal Code</label>
                    <input type="text" wire:model.defer="postal_code" class="form-control"
                        placeholder="ZIP / Postal Code">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <input type="text" wire:model.defer="country" class="form-control" placeholder="Pakistan">
                </div>
                <div class="col-12">
                    <label class="form-label">Street Address <span class="text-danger">*</span></label>
                    <input type="text" wire:model.defer="address_line_1" class="form-control @error('address_line_1') is-invalid @enderror"
                        placeholder="123 Example Street">
                    @error('address_line_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <input type="text" wire:model.defer="address_line_2" class="form-control mt-2"
                        placeholder="Address line 2 (optional)">
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_default" wire:model.defer="is_default">
                        <label class="form-check-label" for="is_default">
                            Set as default address
                        </label>
                    </div>
                </div>
            </div>
        </form>

        <div class="d-flex gap-2 mt-4">
            <button type="button" wire:click="resetForm" class="btn btn-secondary">
                Cancel
            </button>
            <button class="btn btn-primary px-5" wire:click="save">
                <i class="fa-solid fa-save me-2"></i> Save Address
            </button>
        </div>
        
        @error('*')
            <div class="text-danger text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>