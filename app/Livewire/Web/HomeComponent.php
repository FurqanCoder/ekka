<?php

namespace App\Livewire\Web;

use App\Models\FcmToken;
use App\Models\Product;
use App\Services\CartService;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class HomeComponent extends Component
{
    public function testNotification()
{
    $tokens = FcmToken::pluck('token')->toArray();

    $firebase = new FirebaseService();

    $responses = [];

    foreach ($tokens as $token) {
        $responses[] = $firebase->sendNotification(
            $token,
            "Welcome to Our App!",
            "We are excited to have you onboard.",
            [
                "type" => "welcome",
                "message" => "Thanks for joining us"
            ]
        );
    }

    return $responses;
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
       $added = app('wishlist')->toggle($productId);
       $this->dispatch('countWish');
       $this->dispatch('toast', [
           'message' => $added ? 'Added to wishlist.' : 'Removed from wishlist.',
           'type' => 'success',
       ]);
   }

   public function showQuickView($productId)
   {
       $this->emit('showQuickModal', $productId);
   }

   public function render()
{
   $products = Cache::remember('home_featured_products', 600, function () {
       return Product::with([
           'categories',
           'media',
           'prices',
           'variants.optionValues.option'
       ])
       ->where('status', 'live')
       ->orderBy('created_at', 'desc')
       ->limit(12)
       ->get();
   });

   return view('livewire.web.home-component', [
       'products' => $products,
   ])->extends('layouts.web')->section('web-content');
}

}
