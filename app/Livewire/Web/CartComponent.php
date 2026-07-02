<?php

namespace App\Livewire\Web;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class CartComponent extends Component
{
    public $cart = [];
    public $subtotal = 0;
    protected $listeners = [
        'cart-updated' => 'loadCart',
    ];
    public $qty;
    public function mount()
    {
        $this->loadCart();
    }



public function loadCart()
{
    $cartService = app(CartService::class);
    $rawCart = $cartService->getCart();

    $items = $rawCart instanceof \Illuminate\Support\Collection
        ? $rawCart->values()->all()
        : (array) $rawCart;

    if (empty($items)) {
        $this->cart = [];
        $this->subtotal = 0;
        return;
    }

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

    // 👇 calculate subtotal
    $this->subtotal = collect($this->cart)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });
}


    public function removeItem($productId, $variantId = null)
    {
        $cartService = app(CartService::class);
        $cartService->remove($productId, $variantId);

        $this->loadCart();
        $this->dispatch('toast', ['message' => 'Item removed', 'type' => 'success']);
        $this->dispatch('cart-updated');
    }
    public function incrementQty($productId, $variantId = null)
{
    foreach ($this->cart as $index => $item) {
        if (
            $item['product_id'] == $productId &&
            ($variantId === null || $item['variant_id'] == $variantId)
        ) {
            $newQty = $this->cart[$index]['quantity'] + 1;

            $cartService = app(CartService::class);
           $result = $cartService->updateQuantity($productId, $variantId, $newQty);
$this->dispatch('toast', [
        'message' => $result['message'],
        'type'    => $result['status'],
    ]);
            // update local cart array
            $this->cart[$index]['quantity'] = $newQty;

            // recalc subtotal immediately
            $this->subtotal = collect($this->cart)->sum(fn($i) => $i['price'] * $i['quantity']);
            $this->dispatch('cart-updated');

            break;
        }
    }
}

public function decrementQty($productId, $variantId = null)
{
    foreach ($this->cart as $index => $item) {
        if (
            $item['product_id'] == $productId &&
            ($variantId === null || $item['variant_id'] == $variantId)
        ) {
            if ($this->cart[$index]['quantity'] > 1) {
                $newQty = $this->cart[$index]['quantity'] - 1;

                $cartService = app(CartService::class);
               $result = $cartService->updateQuantity($productId, $variantId, $newQty);
                $this->dispatch('toast', [
        'message' => $result['message'],
        'type'    => $result['status'],
    ]);
                // update local cart array
                $this->cart[$index]['quantity'] = $newQty;

                // recalc subtotal immediately
                $this->subtotal = collect($this->cart)->sum(fn($i) => $i['price'] * $i['quantity']);
                $this->dispatch('cart-updated');

            }
            break;
        }
    }
}

    public function render()
    {
        return view('livewire.web.cart-component')->extends('layouts.web')->section('web-content');
    }
}
