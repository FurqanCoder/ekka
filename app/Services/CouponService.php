<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    public function applyCoupon(string $code, $cart)
    {
        $coupon = Coupon::where('code', $code)
            ->where('status', 'active')
            ->with('offer')
            ->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code.'];
        }

        $offer = $coupon->offer;

        // ✅ CASE 1: Coupon linked to Offer
        if ($offer) {
            if (!$offer->isActive()) {
                return ['success' => false, 'message' => 'This coupon is linked to an inactive offer.'];
            }

            if (!$offer->isWithinDateRange()) {
                return ['success' => false, 'message' => 'This offer is not active currently.'];
            }

            if ($offer->min_cart_amount && $cart->subtotal() < $offer->min_cart_amount) {
                return ['success' => false, 'message' => 'Cart total too low for this offer.'];
            }

            // Check per-user usage
            if ($offer->per_user_limit) {
                $usedCount = Coupon::where('code', $code)
                    ->where('used_by', Auth::id())
                    ->count();
                if ($usedCount >= $offer->per_user_limit) {
                    return ['success' => false, 'message' => 'You have already used this coupon.'];
                }
            }

            $discount = $this->calculateDiscount($offer, $cart);
        } 
        // ✅ CASE 2: Standalone Coupon
        else {
            if (!$coupon->isActiveForNow()) {
                return ['success' => false, 'message' => 'This coupon is not active now.'];
            }

            // Check per-user limit
            if ($coupon->per_user_limit) {
                $usedCount = Coupon::where('code', $code)
                    ->where('used_by', Auth::id())
                    ->count();
                if ($usedCount >= $coupon->per_user_limit) {
                    return ['success' => false, 'message' => 'You have already used this coupon.'];
                }
            }

            $discount = $this->calculateCouponDiscount($coupon, $cart);
        }

        if ($discount <= 0) {
            return ['success' => false, 'message' => 'Coupon does not apply to your cart.'];
        }

        // Store in session
        session(['applied_coupon' => [
            'id' => $coupon->id,
            'code' => $code,
            'discount' => $discount,
            'offer_id' => $offer?->id,
        ]]);

        return [
            'success' => true,
            'discount' => $discount,
            'message' => 'Coupon applied successfully!',
        ];
    }

    protected function calculateDiscount(Offer $offer, $cart)
    {
        switch ($offer->discount_type) {
            case 'percentage':
                $discount = ($cart->subtotal() * $offer->discount_value) / 100;
                break;
            case 'fixed':
                $discount = $offer->discount_value;
                break;
            case 'free_shipping':
                $discount = $cart->shipping_cost ?? 0;
                break;
            default:
                $discount = 0;
        }

        if ($offer->max_discount && $discount > $offer->max_discount) {
            $discount = $offer->max_discount;
        }

        return $discount;
    }

    protected function calculateCouponDiscount(Coupon $coupon, $cart)
    {
        switch ($coupon->discount_type) {
            case 'percentage':
                $discount = ($cart->subtotal() * $coupon->discount_value) / 100;
                break;
            case 'fixed':
                $discount = $coupon->discount_value;
                break;
            case 'free_shipping':
                $discount = $cart->shipping_cost ?? 0;
                break;
            default:
                $discount = 0;
        }

        if ($coupon->max_discount && $discount > $coupon->max_discount) {
            $discount = $coupon->max_discount;
        }

        return $discount;
    }
}
