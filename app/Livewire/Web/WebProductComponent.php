<?php

namespace App\Livewire\Web;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Offer;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WebProductComponent extends Component
{
    public $product;
    public $selectedOptions = [];
    public $activeVariant = null;
    public $qty = 1;
    public $activeTab = 'details';
    
    // Offer properties
    public $productPrice = 0;
    public $originalPrice = 0;
    public $discountPercentage = 0;
    public $hasOffer = false;
    public $offerDetails = null;
    public $offerApplied = false;

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

        // Load offers for this product
        $this->loadProductOffers();

        // Preselect first available option for each group
        $options = $this->product->variants
            ->flatMap->optionValues
            ->groupBy(fn($v) => $v->option->name);

        foreach ($options as $optionName => $values) {
            $this->selectedOptions[$optionName] = $values->first()->id;
        }

        // Match default variant on mount
        $this->matchVariant();
    }

    /**
     * Load active offers for this product
     */
    public function loadProductOffers()
    {
        $this->productPrice = $this->product->prices->final_price ?? 0;
        $this->originalPrice = $this->product->prices->original_price ?? $this->productPrice;
        $this->discountPercentage = 0;
        $this->hasOffer = false;
        $this->offerDetails = null;
        $this->offerApplied = false;

        // Get product categories IDs
        $categoryIds = $this->product->categories->pluck('id')->toArray();

        // Check for active offers
        $offer = Offer::active()
            ->where(function($query) use ($categoryIds) {
                $query->where('type', 'global')
                    ->orWhere(function($q) use ($categoryIds) {
                        $q->where('type', 'product')
                            ->whereJsonContains('applies_to', $this->product->id);
                    })
                    ->orWhere(function($q) use ($categoryIds) {
                        $q->where('type', 'category')
                            ->where(function($sub) use ($categoryIds) {
                                foreach ($categoryIds as $id) {
                                    $sub->orWhereJsonContains('applies_to', $id);
                                }
                            });
                    });
            })
            ->first();

        if ($offer) {
            $this->hasOffer = true;
            $this->offerDetails = $offer;
            $this->offerApplied = true;
            
            // Calculate discount
            if ($offer->discount_type === 'percentage') {
                $this->discountPercentage = $offer->discount_value;
                $discountAmount = ($this->originalPrice * $offer->discount_value) / 100;
                $this->productPrice = max(0, $this->originalPrice - $discountAmount);
            } elseif ($offer->discount_type === 'fixed') {
                $this->productPrice = max(0, $this->originalPrice - $offer->discount_value);
                $this->discountPercentage = round((($this->originalPrice - $this->productPrice) / $this->originalPrice) * 100);
            }
        }
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

        // Update variant price with offer
        if ($variant) {
            $variantPrice = $variant->price;
            if ($this->hasOffer && $this->offerDetails) {
                if ($this->offerDetails->discount_type === 'percentage') {
                    $discountAmount = ($variantPrice * $this->offerDetails->discount_value) / 100;
                    $variantPrice = max(0, $variantPrice - $discountAmount);
                } elseif ($this->offerDetails->discount_type === 'fixed') {
                    $variantPrice = max(0, $variantPrice - $this->offerDetails->discount_value);
                }
            }
            $this->productPrice = $variantPrice;
        }

        // Send updated variant image to JS (gallery swap)
        $this->dispatch('variant-selected', image: $variant->image ?? null);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
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

        if ($this->activeVariant) {
            $result = $cartService->add($productId, $this->activeVariant->id, $this->qty);
        } else {
            $product = \App\Models\Product::with('variants')->find($productId);

            if ($product && $product->variants->count() > 0) {
                $this->dispatch('toast', [
                    'message' => 'Please select a variant first!',
                    'type'    => 'error',
                ]);
                return;
            }

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

    public function buyNow($productId)
    {
        $cartService = app(CartService::class);

        if ($this->activeVariant) {
            $result = $cartService->add($productId, $this->activeVariant->id, $this->qty);
        } else {
            $product = Product::with('variants')->find($productId);

            if ($product && $product->variants->count() > 0) {
                $this->dispatch('toast', [
                    'message' => 'Please select a variant first!',
                    'type'    => 'error',
                ]);
                return;
            }

            $result = $cartService->add($productId, null, $this->qty);
        }

        if ($result['status'] === 'success') {
            $this->dispatch('cart-updated');
            $this->dispatch('toast', [
                'message' => 'Redirecting to checkout...',
                'type'    => 'success',
            ]);
            return redirect()->route('web-check-out');
        } else {
            $this->dispatch('toast', [
                'message' => $result['message'] ?? 'Failed to process buy now.',
                'type'    => 'error',
            ]);
        }
    }

    public function render()
    {
        // Group options by their name
        $options = $this->product->variants
            ->flatMap->optionValues
            ->groupBy(fn($v) => $v->option->name);

        // Calculate average rating
        $avgRating = $this->product->reviews->avg('rating') ?? 0;
        $reviewCount = $this->product->reviews->count();

        return view('livewire.web.web-product-component', [
            'product' => $this->product,
            'options' => $options,
            'activeVariant' => $this->activeVariant,
            'avgRating' => $avgRating,
            'reviewCount' => $reviewCount,
            'productPrice' => $this->productPrice,
            'originalPrice' => $this->originalPrice,
            'discountPercentage' => $this->discountPercentage,
            'hasOffer' => $this->hasOffer,
            'offerDetails' => $this->offerDetails,
        ])->extends('layouts.web')->section('web-content');
    }
    public function showLogin()
    {
        $this->dispatch('showLogin');
    }
}