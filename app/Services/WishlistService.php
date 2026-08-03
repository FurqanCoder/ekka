<?php
namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use App\Models\Wishlist;

class WishlistService
{
    protected $cookieName = 'wishlist_items';
    protected $cookieMinutes = 43200; // 30 days

    // Get wishlist items (guest + logged in)
    public function getWishlist()
    {
        if (auth()->check()) {
            return Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray();
        }

        return json_decode(Cookie::get($this->cookieName, '[]'), true);
    }

    public function toggle($productId)
    {
        if (auth()->check()) {
            return $this->toggleForUser($productId);
        }

        return $this->toggleForGuest($productId);
    }

    protected function toggleForUser($productId)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            $exists->delete();
            return false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
            return true;
        }
    }

    protected function toggleForGuest($productId)
    {
        $items = json_decode(Cookie::get($this->cookieName, '[]'), true);

        if (in_array($productId, $items)) {
            $items = array_diff($items, [$productId]);
            $status = false;
        } else {
            $items[] = $productId;
            $status = true;
        }

        Cookie::queue($this->cookieName, json_encode($items), $this->cookieMinutes);

        return $status;
    }
    public function count()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->count();
        }

        $wishlist = collect(json_decode(Cookie::get($this->cookieName, '[]'), true));
        return $wishlist->count();
    }
}
