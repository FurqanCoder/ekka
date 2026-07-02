<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Coupon;
use App\Models\Offer;

class CouponsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Coupon fields
    public $couponId;
    public $code;
    public $offer_id;
    public $discount_type = 'percentage';
    public $discount_value;
    public $usage_limit;
    public $per_user_limit;
    public $min_cart_amount;
    public $max_discount;
    public $start_date;
    public $end_date;
    public $status = true;

    // Generator
    public $generateCount = 10;
    public $generatePrefix = '';

    protected function rules()
    {
        return [
            'code' => 'nullable|string|max:100|unique:coupons,code,' . $this->couponId,
            'offer_id' => 'nullable|exists:offers,id',
            'discount_type' => 'required|in:percentage,fixed,free_shipping',
            'discount_value' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'min_cart_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
        ];
    }

    public function resetForm()
    {
        $this->couponId = null;
        $this->code = null;
        $this->offer_id = null;
        $this->discount_type = 'percentage';
        $this->discount_value = null;
        $this->usage_limit = null;
        $this->per_user_limit = null;
        $this->min_cart_amount = null;
        $this->max_discount = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->status = true;
    }

    /* ------------------------------
       CRUD Operations
    -------------------------------*/

    public function create()
    {
        $this->resetForm();
        $this->dispatch('show-coupon-modal');
    }

    public function store()
    {
        $this->validate();

        Coupon::create([
            'code' => $this->code ?: Str::upper(Str::random(8)),
            'offer_id' => $this->offer_id,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'usage_limit' => $this->usage_limit,
            'per_user_limit' => $this->per_user_limit,
            'min_cart_amount' => $this->min_cart_amount,
            'max_discount' => $this->max_discount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Coupon created successfully.');
        $this->dispatch('hide-coupon-modal');
        $this->resetForm();
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        $this->couponId = $coupon->id;
        $this->code = $coupon->code;
        $this->offer_id = $coupon->offer_id;
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->usage_limit = $coupon->usage_limit;
        $this->per_user_limit = $coupon->per_user_limit;
        $this->min_cart_amount = $coupon->min_cart_amount;
        $this->max_discount = $coupon->max_discount;
        $this->start_date = optional($coupon->start_date)->format('Y-m-d\TH:i');
        $this->end_date = optional($coupon->end_date)->format('Y-m-d\TH:i');
        $this->status = $coupon->status;

        $this->dispatch('show-coupon-modal');
    }

    public function update()
    {
        $this->validate();

        $coupon = Coupon::findOrFail($this->couponId);

        $coupon->update([
            'code' => $this->code,
            'offer_id' => $this->offer_id,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'usage_limit' => $this->usage_limit,
            'per_user_limit' => $this->per_user_limit,
            'min_cart_amount' => $this->min_cart_amount,
            'max_discount' => $this->max_discount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Coupon updated successfully.');
        $this->dispatch('hide-coupon-modal');
        $this->resetForm();
    }

    public function delete($id)
    {
        Coupon::findOrFail($id)->delete();
        session()->flash('success', 'Coupon deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();
    }

    /* ------------------------------
       Coupon Generator
    -------------------------------*/
    public function generateCoupons()
    {
        $this->validate([
            'generateCount' => 'required|integer|min:1|max:1000',
            'generatePrefix' => 'nullable|string|max:10',
        ]);

        $created = 0;
        for ($i = 0; $i < $this->generateCount; $i++) {
            $code = strtoupper($this->generatePrefix . Str::random(6));

            if (!Coupon::where('code', $code)->exists()) {
                Coupon::create([
                    'code' => $code,
                    'status' => true,
                ]);
                $created++;
            }
        }

        session()->flash('success', "Generated {$created} coupons successfully.");
    }

    public function render()
    {
        $coupons = Coupon::with('offer')
            ->latest()
            ->paginate(12);

        $offers = Offer::active()->get(['id', 'title']);
       // dd($offers);

        return view('livewire.dashboard.coupons-component', [
            'coupons' => $coupons,
            'offers' => $offers,
        ])->extends('layouts.admin')->section('admin-content');
    }
}
