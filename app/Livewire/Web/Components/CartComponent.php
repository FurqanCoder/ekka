<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;
use App\Services\CartService;
use App\Models\Product;

class CartComponent extends Component
{
    public $cart = [];
    public $subtotal = 0;
    protected $listeners = [
        'cart-updated' => 'loadCart',
    ];
    public $qty;
    public function mount()
    {
        $this->loadCart();
    }



    public function loadCart()
    {
        $cartService = app(CartService::class);
        $rawCart = $cartService->getCart();

        $items = $rawCart instanceof \Illuminate\Support\Collection
            ? $rawCart->values()->all()
            : (array) $rawCart;

        if (empty($items)) {
            $this->cart = [];
            $this->subtotal = 0;
            return;
        }

        $productIds = collect($items)->pluck('product_id')->unique();
        $products = Product::with(['variants', 'media', 'prices'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $this->cart = collect($items)->map(function ($item) use ($products) {
            $product = $products->get($item['product_id']);
            $variant = $product?->variants?->firstWhere('id', $item['variant_id']);
            $price = $variant?->price ?? ($product?->prices?->final_price ?? 0);

            return [
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'quantity'   => $item['quantity'],
                'product'    => $product,
                'variant'    => $variant,
                'price'      => $price,
            ];
        })->toArray();

        // 👇 calculate subtotal
        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }


    public function removeItem($productId, $variantId = null)
    {
        $cartService = app(CartService::class);
        $cartService->remove($productId, $variantId);

        $this->loadCart();
        $this->dispatch('toast', ['message' => 'Item removed', 'type' => 'success']);
        $this->dispatch('cart-updated');
    }
    public function incrementQty($productId, $variantId = null)
    {
        $this->loadCart();

        foreach ($this->cart as $index => $item) {
            if (!is_array($item)) {
                continue;
            }

            if (
                ($item['product_id'] ?? null) == $productId &&
                ($variantId === null || ($item['variant_id'] ?? null) == $variantId)
            ) {
                $currentQty = (int) ($this->cart[$index]['quantity'] ?? 0);
                $newQty = $currentQty + 1;

                $cartService = app(CartService::class);
                $result = $cartService->updateQuantity($productId, $variantId, $newQty);
                $this->dispatch('toast', [
                    'message' => $result['message'] ?? 'Cart updated successfully.',
                    'type'    => $result['status'] ?? 'success',
                ]);

                $this->cart[$index]['quantity'] = $newQty;
                $this->subtotal = collect($this->cart)->sum(fn($i) => ((float) ($i['price'] ?? 0)) * (int) ($i['quantity'] ?? 0));
                $this->dispatch('cart-updated');

                break;
            }
        }
    }

    public function decrementQty($productId, $variantId = null)
    {
        $this->loadCart();

        foreach ($this->cart as $index => $item) {
            if (!is_array($item)) {
                continue;
            }

            if (
                ($item['product_id'] ?? null) == $productId &&
                ($variantId === null || ($item['variant_id'] ?? null) == $variantId)
            ) {
                $currentQty = (int) ($this->cart[$index]['quantity'] ?? 0);

                if ($currentQty > 1) {
                    $newQty = $currentQty - 1;

                    $cartService = app(CartService::class);
                    $result = $cartService->updateQuantity($productId, $variantId, $newQty);
                    $this->dispatch('toast', [
                        'message' => $result['message'] ?? 'Cart updated successfully.',
                        'type'    => $result['status'] ?? 'success',
                    ]);

                    $this->cart[$index]['quantity'] = $newQty;
                    $this->subtotal = collect($this->cart)->sum(fn($i) => ((float) ($i['price'] ?? 0)) * (int) ($i['quantity'] ?? 0));
                    $this->dispatch('cart-updated');
                }
                break;
            }
        }
    }



    public function render()
    {
        return view('livewire.web.components.cart-component', [
            'cart' => $this->cart,
        ]);
    }
}
