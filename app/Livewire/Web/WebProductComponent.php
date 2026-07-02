<?php

namespace App\Livewire\Web;

use App\Models\Product;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WebProductComponent extends Component
{
    public $product;
    public $selectedOptions = [];   // optionName => optionValueId
    public $activeVariant = null;
    public $qty = 1;

    public function mount($slug)
    {
        $this->product = Product::with([
            'categories',
            'brand',
            'tags',
            'media',
            'prices',
            'ingredients',
            'instructions',
            'variants.optionValues.option'
        ])->where('slug', $slug)->firstOrFail();

        // ✅ Preselect first available option for each group
        $options = $this->product->variants
            ->flatMap->optionValues
            ->groupBy(fn($v) => $v->option->name);

        foreach ($options as $optionName => $values) {
            $this->selectedOptions[$optionName] = $values->first()->id;
        }

        // Match default variant on mount
        $this->matchVariant();
    }

    public function selectOption($optionName, $valueId)
    {
        $this->selectedOptions[$optionName] = $valueId;
        $this->matchVariant();
    }

    public function matchVariant()
    {
        $variant = $this->product->variants->first(function ($variant) {
            $variantOptionIds = $variant->optionValues->pluck('id')->toArray();
            return empty(array_diff($this->selectedOptions, $variantOptionIds));
        });

        $this->activeVariant = $variant;

        // Send updated variant image to JS (gallery swap)
        $this->dispatch('variant-selected', image: $variant->image ?? null);
    }

    public function decrement()
    {
        if ($this->qty > 1) {
            $this->qty--;
        }
    }

    public function increment()
    {
        $this->qty++;
    }
    public function addCart($productId)
    {
        $cartService = app(\App\Services\CartService::class);

        // Case 1: Product has variants → must select
        if ($this->activeVariant) {
            $result = $cartService->add($productId, $this->activeVariant->id, $this->qty);
        } else {
            // Case 2: No variants → add directly
            $product = \App\Models\Product::with('variants')->find($productId);

            if ($product && $product->variants->count() > 0) {
                // Product HAS variants but user did not select
                $this->dispatch('toast', [
                    'message' => 'Please select a variant first!',
                    'type'    => 'error',
                ]);
                return;
            }

            // Product has NO variants
            $result = $cartService->add($productId, null, $this->qty);
        }

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
        // Group options by their name
        $options = $this->product->variants
            ->flatMap->optionValues
            ->groupBy(fn($v) => $v->option->name);

        return view('livewire.web.web-product-component', [
            'product' => $this->product,
            'options' => $options,
            'activeVariant' => $this->activeVariant
        ])->extends('layouts.web')->section('web-content');
    }
}
