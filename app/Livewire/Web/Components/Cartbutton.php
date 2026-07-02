<?php

namespace App\Livewire\Web\Components;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class Cartbutton extends Component
{
    public $cartCount = 0;
    public $cart;
    protected $listeners = [
        'cart-updated' => 'loadButton',
    ];
    public function mount(){
        $this->loadButton();
    }
    public function loadButton(){
        $cartService = app(CartService::class);
    $rawCart = $cartService->getCart();

    $items = $rawCart instanceof \Illuminate\Support\Collection
        ? $rawCart->values()->all()
        : (array) $rawCart;

    // if (empty($items)) {
    //     $this->cart = [];
    //     $this->subtotal = 0;
    //     return;
    // }

    $productIds = collect($items)->pluck('product_id')->unique();
    $products = Product::with(['variants', 'media', 'prices'])
        ->whereIn('id', $productIds)
        ->get()
        ->keyBy('id');
        $this->cart = collect($items)->map(function ($item) use ($products) {
        $product = $products->get($item['product_id']);
        $variant = $product?->variants?->firstWhere('id', $item['variant_id']);
        $price = $variant?->price ?? ($product?->prices?->final_price ?? 0);

        return [
            'product_id' => $item['product_id'],
            'variant_id' => $item['variant_id'],
            'quantity'   => $item['quantity'],
            'product'    => $product,
            'variant'    => $variant,
            'price'      => $price,
        ];
    })->toArray();
        $this->cartCount = collect($this->cart)->sum('quantity');
    }
    public function render()
    {
        return view('livewire.web.components.cartbutton');
    }
}
