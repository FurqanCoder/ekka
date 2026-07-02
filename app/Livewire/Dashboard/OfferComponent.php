<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;

class OfferComponent extends Component
{
    use WithPagination;

    public $offerId;
    public $title;
    public $type = 'cart';
    public $discount_type = 'percentage';
    public $discount_value;
    public $min_cart_amount;
    public $max_discount;
    public $code; // optional shared code (not required for auto-offers)
    public $usage_limit;
    public $per_user_limit;
    public $applies_to = []; // array of ids
    public $first_order_only = false;
    public $loyalty_points_needed;
    public $stackable = false;
    public $start_date;
    public $end_date;
    public $status = true;
    public $description;

    // frontend helpers
    public $options = []; // for applies_to list (value,label)
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(['product', 'category', 'cart', 'shipping', 'user', 'order'])],
            'discount_type' => ['required', Rule::in(['percentage', 'fixed', 'bogo', 'free_shipping'])],
            'discount_value' => 'nullable|numeric|min:0',
            'min_cart_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'code' => 'nullable|string|max:100',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'applies_to' => 'nullable|array',
            'first_order_only' => 'boolean',
            'loyalty_points_needed' => 'nullable|integer|min:0',
            'stackable' => 'boolean',
            'start_date' => 'nullable|date|after_or_equal:now',
            'end_date'   => 'nullable|date|after_or_equal:start_date|after_or_equal:now',
            'status' => 'boolean',
            'description' => 'nullable|string|max:2000',
        ];
    }

    public function mount()
    {
        $this->loadOptions();
    }

    public function updatedType($value)
    {
        // reset selection when type changes
        $this->applies_to = [];
        $this->loadOptions();
    }

    protected function loadOptions()
    {
        // Prepare options for product/category selection
        if ($this->type === 'product') {
            $this->options = Product::orderBy('name')->limit(1000)->get(['id as value', 'name as label'])->toArray();
        } elseif ($this->type === 'category') {
            $this->options = Category::orderBy('name')->get(['id as value', 'name as label'])->toArray();
        } else {
            $this->options = [];
        }
    }

    public function resetForm()
    {
        $this->offerId = null;
        $this->title = null;
        $this->type = 'cart';
        $this->discount_type = 'percentage';
        $this->discount_value = null;
        $this->min_cart_amount = null;
        $this->max_discount = null;
        $this->code = null;
        $this->usage_limit = null;
        $this->per_user_limit = null;
        $this->applies_to = [];
        $this->first_order_only = false;
        $this->loyalty_points_needed = null;
        $this->stackable = false;
        $this->start_date = null;
        $this->end_date = null;
        $this->status = true;
        $this->description = null;
        $this->loadOptions();
    }

    public function create()
    {
        $this->resetForm();
        $this->dispatch('show-offer-modal');
    }

    public function store()
    {
        $this->validate();

        Offer::create([
            'title' => $this->title,
            'type' => $this->type,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'min_cart_amount' => $this->min_cart_amount,
            'max_discount' => $this->max_discount,
            'code' => $this->code,
            'usage_limit' => $this->usage_limit,
            'per_user_limit' => $this->per_user_limit,
            'applies_to' => $this->applies_to ?: null,
            'first_order_only' => (bool)$this->first_order_only,
            'loyalty_points_needed' => $this->loyalty_points_needed,
            'stackable' => (bool)$this->stackable,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'status' => (bool)$this->status,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Offer created successfully.');
        $this->dispatch('hide-offer-modal');
        $this->resetForm();
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);

        $this->offerId = $offer->id;
        $this->title = $offer->title;
        $this->type = $offer->type;
        $this->discount_type = $offer->discount_type;
        $this->discount_value = $offer->discount_value;
        $this->min_cart_amount = $offer->min_cart_amount;
        $this->max_discount = $offer->max_discount;
        $this->code = $offer->code;
        $this->usage_limit = $offer->usage_limit;
        $this->per_user_limit = $offer->per_user_limit;
        $this->applies_to = $offer->applies_to ?? [];
        $this->first_order_only = (bool)$offer->first_order_only;
        $this->loyalty_points_needed = $offer->loyalty_points_needed;
        $this->stackable = (bool)$offer->stackable;
        $this->start_date = $offer->start_date ? $offer->start_date->format('Y-m-d\TH:i') : null;
        $this->end_date = $offer->end_date ? $offer->end_date->format('Y-m-d\TH:i') : null;
        $this->status = (bool)$offer->status;
        $this->description = $offer->description;

        $this->loadOptions();
        $this->dispatch('show-offer-modal');
    }

    public function update()
    {
        $this->validate();

        $offer = Offer::findOrFail($this->offerId);

        $offer->update([
            'title' => $this->title,
            'type' => $this->type,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'min_cart_amount' => $this->min_cart_amount,
            'max_discount' => $this->max_discount,
            'code' => $this->code,
            'usage_limit' => $this->usage_limit,
            'per_user_limit' => $this->per_user_limit,
            'applies_to' => $this->applies_to ?: null,
            'first_order_only' => (bool)$this->first_order_only,
            'loyalty_points_needed' => $this->loyalty_points_needed,
            'stackable' => (bool)$this->stackable,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'status' => (bool)$this->status,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Offer updated successfully.');
        $this->dispatch('hide-offer-modal');
        $this->resetForm();
    }

    public function delete($id)
    {
        Offer::findOrFail($id)->delete();
        session()->flash('success', 'Offer deleted.');
    }

    public function toggle($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->status = !$offer->status;
        $offer->save();
    }

    public function render()
    {
        $offers = Offer::withCount('coupons')
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.dashboard.offer-component', compact('offers'))->extends('layouts.admin')->section('admin-content');
    }
}
