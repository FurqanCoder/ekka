<?php

namespace App\Livewire\Web;

use App\Models\FcmToken;
use App\Models\Product;
use App\Services\FirebaseService;
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
   public function render()
{
    $products = Product::with([
    'categories',
    'media',
    'prices',
    'variants.optionValues.option'  // this is correct
])->get();

    return view('livewire.web.home-component', [
        'products' => $products,
    ])->extends('layouts.web')->section('web-content');
}

}
