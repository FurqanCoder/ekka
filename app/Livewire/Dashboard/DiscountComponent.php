<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Category;

class DiscountComponent extends Component
{
    use WithPagination;

    // Form fields
    public $discountId;
    public $title;
    public $type = 'percentage';
    public $value;
    public $code;
    public $start_date;
    public $end_date;
    public $active = true;
    public $product_id;
    public $category_id;

    public $products = [];
    public $categories = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'type' => 'required|in:percentage,fixed,buy_one_get_one',
        'value' => 'nullable|numeric|min:0',
        'code' => 'nullable|string|max:50|unique:discounts,code',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'active' => 'boolean',
        'product_id' => 'nullable|exists:products,id',
        'category_id' => 'nullable|exists:categories,id',
    ];

    public function mount()
    {
        $this->products = Product::all();
        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validate();

        $discount = $this->discountId
            ? Discount::findOrFail($this->discountId)
            : new Discount();

        $discount->fill([
            'title' => $this->title,
            'type' => $this->type,
            'value' => $this->value,
            'code' => $this->code,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'active' => $this->active,
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
        ])->save();

        session()->flash('success', 'Discount saved successfully!');

        $this->resetInput();
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);

        $this->discountId = $discount->id;
        $this->title = $discount->title;
        $this->type = $discount->type;
        $this->value = $discount->value;
        $this->code = $discount->code;
        $this->start_date = $discount->start_date;
        $this->end_date = $discount->end_date;
        $this->active = $discount->active;
        $this->product_id = $discount->product_id;
        $this->category_id = $discount->category_id;
    }

    public function delete($id)
    {
        Discount::findOrFail($id)->delete();
        session()->flash('success', 'Discount deleted!');
    }

    private function resetInput()
    {
        $this->discountId = null;
        $this->title = '';
        $this->type = 'percentage';
        $this->value = null;
        $this->code = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->active = true;
        $this->product_id = null;
        $this->category_id = null;
    }

    public function render()
    {
        return view('livewire.dashboard.discount-component', [
            'discounts' => Discount::latest()->paginate(10),
        ])->extends('layouts.admin')->section('admin-content');
    }
}
