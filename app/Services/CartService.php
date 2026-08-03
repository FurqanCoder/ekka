<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    protected $cookieName = 'user_cart';
    protected $cookieMinutes = 43200; // 30 days

    /**
     * Get current cart (guest or logged-in).
     */
    public function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->get();
        }

        return collect(json_decode(Cookie::get($this->cookieName, '[]'), true));
    }

    /**
     * Add a product to the cart.
     */
    public function add($productId, $variantId = null, $quantity = 1)
    {
        if (Auth::check()) {
            $this->addToDatabase($productId, $variantId, $quantity);
        } else {
            $this->addToCookie($productId, $variantId, $quantity);
        }

        return [
            'status'  => 'success',
            'message' => 'Product added to cart successfully!',
        ];
    }

    /**
     * Add item to logged-in user's database cart.
     */
    protected function addToDatabase($productId, $variantId, $quantity)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($cart) {
            $cart->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity'   => $quantity,
                
            ]);
        }
    }

    /**
     * Add item to guest cart (stored in cookies).
     */
    protected function addToCookie($productId, $variantId, $quantity)
    {
        $cart = collect(json_decode(Cookie::get($this->cookieName, '[]'), true));

        $found = false;
        $cart = $cart->map(function ($item) use ($productId, $variantId, $quantity, &$found) {
            if ($item['product_id'] == $productId && $item['variant_id'] == $variantId) {
                $item['quantity'] += $quantity;
                $found = true;
            }
            return $item;
        });

        if (!$found) {
            $cart->push([
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity'   => $quantity,
            ]);
        }

        Cookie::queue($this->cookieName, json_encode($cart), $this->cookieMinutes);
    }

    /**
     * Update quantity.
     */
    public function updateQuantity($productId, $variantId = null, $quantity = 1)
    {
        $normalizedQuantity = max(1, (int) $quantity);

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->update(['quantity' => $normalizedQuantity]);
        } else {
            $cart = collect(json_decode(Cookie::get($this->cookieName, '[]'), true));
            $cart = $cart->map(function ($item) use ($productId, $variantId, $normalizedQuantity) {
                if (!is_array($item)) {
                    return null;
                }

                if (($item['product_id'] ?? null) == $productId && ($item['variant_id'] ?? null) == $variantId) {
                    $item['quantity'] = $normalizedQuantity;
                }

                return $item;
            })->filter()->values();

            Cookie::queue($this->cookieName, json_encode($cart), $this->cookieMinutes);
        }

        return [
            'status' => 'success',
            'message' => 'Cart updated successfully.',
        ];
    }

    /**
     * Remove item from cart.
     */
    public function remove($productId, $variantId = null)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->delete();
        } else {
            $cart = collect(json_decode(Cookie::get($this->cookieName, '[]'), true))
                ->reject(fn($item) => $item['product_id'] == $productId && $item['variant_id'] == $variantId);
            Cookie::queue($this->cookieName, json_encode($cart->values()), $this->cookieMinutes);
        }
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        }

        Cookie::queue(Cookie::forget($this->cookieName));
    }

    /**
     * Merge guest cart (cookie) into logged-in user's database cart after login.
     */
    public function mergeGuestCartWithUserCart($userId)
    {
        $guestCart = collect(json_decode(Cookie::get($this->cookieName, '[]'), true));

        if ($guestCart->isEmpty()) {
            return;
        }

        foreach ($guestCart as $item) {
            $existing = Cart::where('user_id', $userId)
                ->where('product_id', $item['product_id'])
                ->where('variant_id', $item['variant_id'])
                ->first();

            if ($existing) {
                $existing->increment('quantity', $item['quantity']);
            } else {
                Cart::create([
                    'user_id'    => $userId,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity'   => $item['quantity'],
                ]);
            }
        }

        // ✅ Clear cookie cart after merging
        Cookie::queue(Cookie::forget($this->cookieName));
    }
    public function count()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }

        $cart = collect(json_decode(Cookie::get($this->cookieName, '[]'), true));
        return $cart->sum('quantity');
    }
    public function isEmpty()
    {
        return $this->count() === 0;
    }
    
}
