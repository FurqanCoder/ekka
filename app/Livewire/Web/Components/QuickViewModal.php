<?php

namespace App\Livewire\Web\Components;

use App\Models\Product;
use Livewire\Component;

class QuickViewModal extends Component
{
    public $product = null;               // Single Product model
    public $selectedOptions = [];         // optionName => optionValueId
    public $activeVariant = null;
    public $qty = 1;

    protected $listeners = ['showQuickModal' => 'showModal'];

    public function showModal($product_id)
    {
        dd($product_id);
        // Always load a single model, never a collection
        $this->product = Product::with([
            'categories',
            'brand',
            'tags',
            'media',
            'prices',
            'ingredients',
            'instructions',
            'variants.optionValues.option'
        ])->findOrFail($product_id);

        $this->selectedOptions = [];
        $this->qty = 1;
        $this->activeVariant = null;

        // Preselect first option per group if variants exist
        if ($this->product->variants && $this->product->variants->count() > 0) {
            $options = $this->product->variants
                ->flatMap->optionValues
                ->groupBy(fn($v) => $v->option->name);

            foreach ($options as $optionName => $values) {
                $this->selectedOptions[$optionName] = $values->first()->id;
            }
        }

        $this->matchVariant();

        $this->dispatch('showmodal');
    }

    public function selectOption($optionName, $valueId)
    {
        $this->selectedOptions[$optionName] = $valueId;
        $this->matchVariant();
    }

    public function matchVariant()
    {
        $this->activeVariant = null;

        if (!$this->product || !$this->product->variants || $this->product->variants->count() === 0) {
            return;
        }

        foreach ($this->product->variants as $variant) {
            $variantOptionIds = $variant->optionValues->pluck('id')->toArray();
            if (!array_diff($this->selectedOptions, $variantOptionIds)) {
                $this->activeVariant = $variant;
                break;
            }
        }

        $this->dispatch('variant-selected', [
            'image' => $this->activeVariant->image ?? null
        ]);
    }

    public function decrement()
    {
        if ($this->qty > 1) $this->qty--;
    }

    public function increment()
    {
        $this->qty++;
    }

    public function addCart($productId)
    {
        $cartService = app(\App\Services\CartService::class);

        if ($this->activeVariant) {
            $result = $cartService->add($productId, $this->activeVariant->id, $this->qty);
        } else {
            $product = Product::with('variants')->find($productId);

            if ($product && $product->variants && $product->variants->count() > 0) {
                $this->dispatch('toast', [
                    'message' => 'Please select a variant first!',
                    'type' => 'error',
                ]);
                return;
            }

            $result = $cartService->add($productId, null, $this->qty);
        }

        $this->dispatch('toast', [
            'message' => $result['message'],
            'type' => $result['status'],
        ]);

        if ($result['status'] === 'success') {
            $this->dispatch('cart-updated');
        }
    }

    public function render()
    {
        dd($this->product);
        $options = collect();

        if ($this->product && $this->product->variants && $this->product->variants->count() > 0) {
            $options = $this->product->variants
                ->flatMap->optionValues
                ->groupBy(fn($v) => $v->option->name);
        }

        return view('livewire.web.components.quick-view-modal', [
            'product' => $this->product,
            'options' => $options,
            'activeVariant' => $this->activeVariant,
        ]);
    }
}
