<?php

namespace App\Livewire\Web\Components;

use App\Services\CartService;
use App\Services\CouponService;
use Livewire\Component;

class CartCouponComponent extends Component
{
    public $code;
    public $message;
    public $discount = 0;

    public function applyCoupon()
    {
        $cart = app(CartService::class);
        $couponService = app(CouponService::class);

        $result = $couponService->applyCoupon($this->code, $cart);

        $this->message = $result['message'];

        if ($result['success']) {
            $this->discount = $result['discount'];
            $this->dispatch('couponApplied');
        }
        
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        $this->code = '';
        $this->discount = 0;
        $this->message = 'Coupon removed.';
        $this->dispatch('couponRemoved');
    }

    public function render()
    {
        return view('livewire.web.components.cart-coupon-component',[
            'applied' => session('applied_coupon')
        ]);
    }
}
