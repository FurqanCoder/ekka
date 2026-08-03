<?php

namespace App\Livewire\Web\Dashboard;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class UserWishlist extends Component
{
    public $wishlistItems = [];

    public function mount()
    {
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        $this->wishlistItems = Wishlist::with(['product.media', 'product.prices'])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $product = $item->product;
                if (!$product) {
                    return null;
                }
                return [
                    'id' => $item->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->media->first()->file_path ?? asset('web/images/placeholder.jpg'),
                    'price' => $product->prices->final_price ?? 0,
                    'original_price' => $product->prices->original_price ?? null,
                    'in_stock' => $product->stock > 0,
                    'added_at' => $item->created_at->diffForHumans(),
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }

    public function removeFromWishlist($wishlistId)
    {
        Wishlist::where('id', $wishlistId)
            ->where('user_id', Auth::id())
            ->delete();

        $this->loadWishlist();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Removed from wishlist']);
        $this->dispatch('wishlist-updated');
    }

    public function addToCart($productId)
    {
        // Add to cart logic
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Added to cart']);
    }
    

    public function render()
    {
        return view('livewire.web.dashboard.user-wishlist');
    }
}