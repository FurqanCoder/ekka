<?php

namespace App\Livewire\Web\Components\Single;

use App\Models\Product;
use Livewire\Component;

class RelatedProducts extends Component
{
    public $product;
public $products = [];

public function mount($id)
{
    // Load the main product
    $this->product = Product::with([
        'categories',
        'media',
        'prices',
        'variants.optionValues.option'
    ])->findOrFail($id);

    // Get category IDs of current product
    $categoryIds = $this->product->categories->pluck('id')->toArray();

    // Fetch related products
    $this->products = Product::whereHas('categories', function ($q) use ($categoryIds) {
        $q->whereIn('categories.id', $categoryIds);
    })
    ->where('id', '!=', $this->product->id)   // exclude same product
    ->with([
        'media',
        'prices'
    ])
    ->limit(4) // show 8 related products
    ->get();
}

    public function render()
    {
        return view('livewire.web.components.single.related-products');
    }
}
