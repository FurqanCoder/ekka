<?php

namespace App\Livewire\Web\Dashboard;

use Livewire\Component;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class UserAddresses extends Component
{
    public $addresses;
    public $showForm = false;
    public $editingId = null;
    
    // Form fields
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

    public function mount()
    {
        $this->loadAddresses();
    }

    public function loadAddresses()
    {
        $this->addresses = Address::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function showCreate()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
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
                if ($address->user_id !== Auth::id()) {
                    abort(403);
                }
                $address->update($payload);
            } else {
                $payload['user_id'] = Auth::id();
                $address = Address::create($payload);
            }

            if ($payload['is_default']) {
                Address::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
        });

        $this->resetForm();
        $this->loadAddresses();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Address saved successfully!']);
    }

    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        if ($address->is_default) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Cannot delete default address. Set another address as default first.']);
            return;
        }

        $address->delete();
        $this->loadAddresses();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Address deleted successfully!']);
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($address) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        $this->loadAddresses();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Default address updated!']);
    }

    public function resetForm()
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

    public function render()
    {
        return view('livewire.web.dashboard.user-addresses');
    }
}