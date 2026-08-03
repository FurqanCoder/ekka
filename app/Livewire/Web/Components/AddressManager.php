<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AddressManager extends Component
{
    public $addresses;
    public $showForm = false;
    public $editingId = null;
    public $label_type = 'home';
    public $custom_label;
    // form fields
    public $label;
    public $name;
    public $phone;
    public $country = 'Pakistan';
    public $province;
    public $city;
    public $postal_code;
    public $address_line_1;
    public $address_line_2;
    public $is_default = false;
    public $selectedAddressId = null;

    protected $rules = [
        'name' => 'required|string|max:191',
        'phone' => 'required|string|max:32',
        'country' => 'required|string|max:64',
        'province' => 'nullable|string|max:128',
        'city' => 'required|string|max:128',
        'postal_code' => 'nullable|string|max:32',
        'address_line_1' => 'required|string|max:1000',
        'address_line_2' => 'nullable|string|max:1000',
        'label' => 'nullable|string|max:64',
        'is_default' => 'boolean',
    ];

    protected $listeners = [
        'addressSaved' => 'loadAddresses'
    ];

    public function mount()
    {
        // Fix: Check if user is logged in before accessing addresses
        if (Auth::check()) {
            $this->selectedAddressId = Auth::user()->addresses()->where('is_default', 1)->value('id');
        } else {
            $this->selectedAddressId = null;
        }
        $this->loadAddresses();
    }

    public function gotoPayment()
    {
        if (!$this->selectedAddressId) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Please select an address first.']);
            return;
        }
        
        session(['activeAddress' => $this->selectedAddressId]);
        $this->dispatch('goTotab', 'payment');
    }

    public function loadAddresses()
    {
        $this->addresses = Auth::check()
            ? Auth::user()->addresses()->get()
            : collect(); // Return empty collection instead of null
    }

    public function showCreate()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function edit(Address $address)
    {
        // security: if user is authenticated ensure they own address
        if (Auth::check() && $address->user_id !== Auth::id()) {
            abort(403);
        }

        $this->editingId = $address->id;
        $this->label = $address->label;
        $this->name = $address->name;
        $this->phone = $address->phone;
        $this->country = $address->country;
        $this->province = $address->province;
        $this->city = $address->city;
        $this->postal_code = $address->postal_code;
        $this->address_line_1 = $address->address_line_1;
        $this->address_line_2 = $address->address_line_2;
        $this->is_default = (bool)$address->is_default;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        // Fix: Check if user is logged in before saving
        if (!Auth::check()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Please login to save address']);
            return;
        }

        DB::transaction(function () {
            $payload = [
                'label' => $this->label,
                'name' => $this->name,
                'phone' => $this->phone,
                'country' => $this->country,
                'province' => $this->province,
                'city' => $this->city,
                'postal_code' => $this->postal_code,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'is_default' => $this->is_default ? true : false,
            ];

            if ($this->editingId) {
                $address = Address::findOrFail($this->editingId);
                // auth check
                if (Auth::check() && $address->user_id !== Auth::id()) {
                    abort(403);
                }
                $address->update($payload);
            } else {
                $payload['user_id'] = Auth::id();
                $address = Address::create($payload);
            }

            // if marked default, unset others atomically
            if ($payload['is_default']) {
                Address::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
        });

        $this->resetForm();
        $this->loadAddresses();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Address saved successfully!']);
        
        // Auto-select the newly saved address if it's the only one
        if ($this->addresses->count() == 1) {
            $this->selectedAddressId = $this->addresses->first()->id;
            session(['activeAddress' => $this->selectedAddressId]);
            
            // Go to payment tab automatically
            $this->dispatch('goTotab', 'payment');
        }
    }

    public function deleteAddress(Address $address)
    {
        if (Auth::check() && $address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        $this->loadAddresses();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Address removed']);
    }

    public function setDefault(Address $address)
    {
        if (Auth::check() && $address->user_id !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($address) {
            Address::where('user_id', $address->user_id)->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        $this->loadAddresses();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Default address updated!']);
    }

    protected function resetForm()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->label = null;
        $this->name = null;
        $this->phone = null;
        $this->country = 'Pakistan';
        $this->province = null;
        $this->city = null;
        $this->postal_code = null;
        $this->address_line_1 = null;
        $this->address_line_2 = null;
        $this->is_default = false;
        $this->resetValidation();
    }

    public function selectAddress($id)
    {
        $this->selectedAddressId = $id;
        // store active address centrally (session)
        session(['activeAddress' => $id]);

        // notify parent checkout to go to payment automatically
        $this->dispatch('goTotab', 'payment');
    }

    public function render()
    {
        return view('livewire.web.components.address-manager');
    }
}