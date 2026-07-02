<?php

namespace App\Livewire\Web\Components\Wish;

use App\Models\Product;
use App\Models\Wishlist;
use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class WishManager extends Component
{
    protected $listeners = ['countWish' => 'updateCount'];
    public function updateCount(){
        $this->dispatch('refresh');
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
