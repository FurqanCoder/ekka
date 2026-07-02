<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;
use App\Services\CartService;
use App\Models\Product;

class AddCartButton extends Component
{
    public $productId;

    public function mount($id)
    {
        $this->productId = $id;
    }

    public function addCart()
    {
        $cartService = app(CartService::class);

        $product = Product::with('variants')->find($this->productId);

        if ($product && $product->variants->count() > 0) {
            // product has variants → force user to choose
            $this->dispatch('toast', [
                'message' => 'Please select a variant before adding to cart!',
                'type'    => 'error',
            ]);
            return;
        }

        // product without variants → safe to add
        $result = $cartService->add($this->productId, null, 1);

        $this->dispatch('toast', [
            'message' => $result['message'],
            'type'    => $result['status'],
        ]);

        if ($result['status'] === 'success') {
            $this->dispatch('cart-updated');
        }
    }

    public function render()
    {
        return view('livewire.web.components.add-cart-button');
    }
}
