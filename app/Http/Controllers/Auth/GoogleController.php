<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        // Save the intended URL to redirect later
        session(['url.intended' => $request->input('redirect', url()->previous())]);
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Find or create the user
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'          => $googleUser->getName(),
                'provider_id'   => $googleUser->getId(),
                'password'      => bcrypt(str()->random(16)),
                'avatar'        => $googleUser->getAvatar(),
                'provider_name' => 'google',
            ]
        );

        // Assign default customer role if not already assigned
        // if (!$user->hasRole('customer')) {
        //     $user->assignRole('customer');
        // }

        // Log in the user
        Auth::login($user);

        // ✅ Merge guest cart (session) into user cart in database
        app(\App\Services\CartService::class)->mergeGuestCartWithUserCart($user->id);
        $guestItems = json_decode(Cookie::get('wishlist_items', '[]'), true);

        foreach ($guestItems as $productId) {
            Wishlist::firstOrCreate([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
        }

        Cookie::queue(Cookie::forget('wishlist_items'));

        // Redirect user back to intended page (or home)
        return redirect()->intended('/');
    }
}
