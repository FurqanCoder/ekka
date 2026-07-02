<?php

namespace App\Livewire\Dashboard;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product deleted successfully.');
    }

    public function render()
    {
        $query = Product::with(['categories', 'variants','media','prices'])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%");
            });

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $products = $query->latest()->paginate(10);

        return view('livewire.dashboard.product-component', [
            'products' => $products,
        ])->extends('layouts.admin')->section('admin-content');
    }
}
