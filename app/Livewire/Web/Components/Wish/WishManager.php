<?php

namespace App\Livewire\Web\Components\Wish;

use App\Models\Product;
use App\Models\Wishlist;
use App\Services\CartService;
use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class WishManager extends Component
{
    protected $listeners = ['countWish' => 'updateCount'];
    public function updateCount(){
        $this->dispatch('refresh');
    }

    public function addToCart($productId)
    {
        $cartService = app(CartService::class);
        $product = Product::with('variants')->find($productId);

        if (!$product) {
            $this->dispatch('toast', [
                'message' => 'Product not found.',
                'type' => 'error',
            ]);
            return;
        }

        if ($product->variants->count() > 0) {
            $this->dispatch('toast', [
                'message' => 'Please select a variant on the product page.',
                'type' => 'error',
            ]);
            return;
        }

        $result = $cartService->add($productId, null, 1);
        $this->dispatch('toast', [
            'message' => $result['message'],
            'type' => $result['status'],
        ]);

        if ($result['status'] === 'success') {
            $this->dispatch('cart-updated');
        }
    }

    public function toggleWishlist($productId)
    {
        app('wishlist')->toggle($productId);
        $this->dispatch('countWish');
        $this->dispatch('toast', [
            'message' => 'Wishlist updated.',
            'type' => 'success',
        ]);
    }

    public function showQuickView($productId)
    {
        $this->emit('showQuickModal', $productId);
    }

    public function render()
    {
        $products = collect();

        if (auth()->check()) {
            $wishItems = Wishlist::where('user_id', auth()->id())->get();
            $productIds = $wishItems->pluck('product_id')->toArray();

            $products = Product::whereIn('id', $productIds)
                ->with(['categories', 'media', 'prices', 'variants.optionValues.option'])
                ->get();
        } else {
            // Guest: get wishlist from cookie
            $wishItems = json_decode(Cookie::get('wishlist_items', '[]'), true);
            if (!empty($wishItems)) {
                $products = Product::whereIn('id', $wishItems)
                    ->with(['categories', 'media', 'prices', 'variants.optionValues.option'])
                    ->get();
            }
        }

        return view('livewire.web.components.wish.wish-manager', [
            'products' => $products,
        ])->extends('layouts.web')->section('web-content');
    }
}
