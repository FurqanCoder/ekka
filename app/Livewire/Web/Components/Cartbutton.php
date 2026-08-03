<?php

namespace App\Livewire\Web\Components;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Cartbutton extends Component
{
    public $cartCount = 0;
    public $cart;
    protected $listeners = [
        'cart-updated' => 'loadButton',
    ];

    public function mount()
    {
        $this->loadButton();
    }

    public function loadButton()
    {
        if (auth()->check()) {
            $this->cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
            return;
        }

        $items = json_decode(Cookie::get('user_cart', '[]'), true);

        if (!is_array($items) || empty($items)) {
            $this->cartCount = 0;
            return;
        }

        $this->cartCount = array_sum(array_column($items, 'quantity'));
    }
    public function render()
    {
        return view('livewire.web.components.cartbutton');
    }
}
