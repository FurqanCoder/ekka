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

        /* FORCE ONE LINE ALWAYS  */
        .address-options-wrapper {
            display: flex;
            gap: 12px;
            width: 100%;
            flex-wrap: nowrap;
        }
    </style>

    <div class="tab-pane fade show active" id="shipping" role="tabpanel">
        @if ($addresses->count() > 0)
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Saved addresses</h3>
                <button wire:click="showCreate" class="btn btn-primary">Add address</button>
            </div>
            <div class="grid gap-3 mb-3"
                style="
                        width:98%;
                        margin:0 auto;
                        display:grid;
                        justify-content:center;
                        align-content:center
                ">
                @forelse($addresses as $addr)
                    @php
                        $isSelected = $selectedAddressId === $addr->id;
                        // Base container styles
                        $baseStyle =
                            'position:relative; display:flex; justify-content:space-between; align-items:flex-start;' .
                            'padding:16px; border-radius:12px; cursor:pointer; transition: all 0.18s ease;';
                        // Selected vs unselected overrides
                        $selectedStyle =
                            'border:2px solid #2563EB; background:#EFF6FF; box-shadow:0 8px 20px rgba(37,99,235,0.12); transform:scale(1.02);';
                        $unselectedStyle = 'border:1px solid #D1D5DB; background:#FFFFFF;';
                        $containerStyle = $baseStyle . ($isSelected ? $selectedStyle : $unselectedStyle);
                        // Small text styles
                        $labelStyle = 'margin:0; font-weight:700; color:#111827;';
                        $metaStyle = 'margin-top:6px; font-size:14px; color:#374151;';
                        $subMetaStyle = 'margin-top:6px; font-size:13px; color:#6B7280;';
                        // Button styles
                        $btnBase =
                            'padding:8px 12px; font-size:13px; border-radius:8px; border:1px solid transparent; cursor:pointer; transition:all 0.12s ease;';
                        $btnDefault = $btnBase . 'background:#FFFFFF; color:#111827; border:1px solid #D1D5DB;';
                        $btnSecondary = $btnBase . 'background:#F3F4F6; color:#111827; border:1px solid #e5e7eb;';
                        $btnDanger = $btnBase . 'background:#EF4444; color:#FFFFFF; border:1px solid #EF4444;';
                    @endphp

                    <div wire:click="selectAddress({{ $addr->id }})" class=""
                        wire:keydown.enter="selectAddress({{ $addr->id }})" role="button" tabindex="0"
                        style="{{ $containerStyle }}" aria-pressed="{{ $isSelected ? 'true' : 'false' }}">
                        {{-- SELECTED BADGE --}}
                        @if ($isSelected)
                            <div
                                style="position:absolute; top:-10px; right:-10px; background:#2563EB; color:#FFFFFF;
                        padding:6px 12px; border-radius:999px; font-size:12px; font-weight:600;
                        box-shadow:0 6px 14px rgba(37,99,235,0.12);">
                                Selected
                            </div>
                        @endif

                        {{-- Left content --}}
                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <p style="{{ $labelStyle }}">{{ $addr->label ?? 'Address' }}</p>

                                @if ($addr->is_default)
                                    <span
                                        style="margin-left:6px; font-size:12px; padding:4px 8px; border-radius:8px;
                                 background:#DCFCE7; color:#065F46; font-weight:600;">
                                        Default
                                    </span>
                                @endif
                            </div>

                            <div style="{{ $metaStyle }}">{{ $addr->full_address }}</div>
                            <div style="{{ $subMetaStyle }}">{{ $addr->name }} — {{ $addr->phone }}</div>
                        </div>

                        {{-- Right actions --}}
                        <div style="display:flex; gap:8px; margin-left:16px; align-items:flex-start;">

                            @if (!$addr->is_default)
                                <button wire:click.stop="setDefault({{ $addr->id }})" type="button"
                                    style="{{ $btnDefault }}" title="Set as default address">
                                    Set default
                                </button>
                            @endif

                            <button wire:click.stop="edit({{ $addr->id }})" type="button"
                                style="{{ $btnSecondary }}" title="Edit address">
                                Edit
                            </button>

                            <button wire:click.stop="deleteAddress({{ $addr->id }})" type="button"
                                style="{{ $btnDanger }}"
                                onclick="if(!confirm('Delete this address?')) event.stopImmediatePropagation();"
                                title="Delete address">
                                Delete
                            </button>
                        </div>
                    </div>
                @empty
                    <p style="color:#6B7280; font-size:14px;">No addresses available.</p>
                @endforelse

            </div>
            <button class="btn btn-primary float-right mb-3" wire:click="gotoPayment">Proceed Now</button>
            <hr>
        @endif

        <h5 class="mb-3">Shipping Information</h5>
        <div class="address-options-wrapper">

            <!-- Home -->
            <div class="address-option">
                <input type="radio" wire:model.defer="label" id="home" name="address_type" value="home"
                    checked>
                <label for="home">
                    <span class="label-icon" style="font-size: large">🏠</span>
                    Home
                </label>
            </div>

            <!-- Office -->
            <div class="address-option">
                <input type="radio" id="office" wire:model.defer="label" name="address_type" value="office">
                <label for="office">
                    <span class="label-icon" style="font-size: large">🏢</span>
                    Office
                </label>
            </div>

            <!-- Other -->
            <div class="address-option">
                <input type="radio" id="other" wire:model.defer="label" name="address_type" value="other">
                <label for="other">
                    <span class="label-icon" style="font-size: large">✨</span>
                    Other
                </label>
            </div>

        </div>
        <form id="shippingForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="shipping_name" wire:model.defer="name" class="form-control"
                        placeholder="John Doe">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="shipping_phone" wire:model.defer="phone" class="form-control"
                        placeholder="0300 1234567">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="shipping_email" value="{{ auth()->user()->email }}" readonly
                        class="form-control" placeholder="you@example.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label">State</label>
                    <select name="" id="" wire:model.defer="province" class="form-control border">
                        <option value="Punjab" class="form-control">Punjab</option>
                        <option value="Sindh" class="form-control">Sindh</option>
                        <option value="KPK" class="form-control">KPK</option>
                        <option value="Balochistan" class="form-control">Balochistan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" wire:model.defer="city" name="shipping_city" class="form-control"
                        placeholder="City Name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Postal Code</label>
                    <input type="text" wire:model.defer="postal_code" name="shipping_postal" class="form-control"
                        placeholder="ZIP / Postal Code">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Street Address</label>
                    <input type="text" wire:model.defer="address_line_1" name="shipping_address"
                        class="form-control" placeholder="123 Example Street">
                    <input type="text" wire:model.defer="address_line_2" name="shipping_address"
                        class="form-control mt-2" placeholder="Address line 2 (optional)">
                </div>


                <div class="col-12 flex items-center gap-3 mt-2">
                    <div class="form-check d-flex">
                        <label class="inline-flex items-center">
                            <input type="checkbox"
                                style="width:16px; height:16px; transform: scale(1.3); margin-right:6px;"
                                wire:model.defer="is_default" checked>
                            <span class="text-sm">Set as default</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>

        <div class="text-end mt-4">
            <button type="button" wire:click="resetForm" class="btn btn-secondary">Cancel</button>
            <button class="btn btn-primary px-5" type="submit" wire:click="save">
                Save & Continue to Payment
            </button>

        </div>
        @error('*')
            <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
    </div>
</div>
