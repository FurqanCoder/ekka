<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\Tag;
use App\Services\CartService;
use Illuminate\Support\Facades\Cache;

class ShopComponent extends Component
{
    use WithPagination;

    // Filter inputs - what user selects
    public $selectedCategories = [];
    public $selectedSizes = [];
    public $selectedColors = [];
    public $selectedMaterial = [];
    public $minPrice = '';
    public $maxPrice = '';
    
    // Live filters
    #[Url(as: 'sort')]
    public $sort = '';
    
    #[Url(as: 'q')]
    public $search = '';

    // Sidebar options
    public $categories;
    public $sizes;
    public $colors;
    public $material;
    public $tags;

    // Applied filters - what's actually used for filtering
    #[Url(as: 'cat')]
    public $appliedCategories = [];
    
    #[Url(as: 'size')]
    public $appliedSizes = [];
    
    #[Url(as: 'color')]
    public $appliedColors = [];
    
    #[Url(as: 'mat')]
    public $appliedMaterial = [];
    
    #[Url(as: 'min')]
    public $appliedMinPrice = '';
    
    #[Url(as: 'max')]
    public $appliedMaxPrice = '';

    public function mount()
    {
        // Cache static shop filters for faster page loads
        $this->categories = Cache::remember('shop_filters.categories', 3600, function () {
            return Category::with('children')->whereNull('parent_id')->get();
        });

        $this->sizes = Cache::remember('shop_filters.sizes', 3600, function () {
            return ProductOption::where('name', 'Size')->first()?->values ?? [];
        });

        $this->colors = Cache::remember('shop_filters.colors', 3600, function () {
            return ProductOption::where('name', 'Color')->first()?->values ?? [];
        });

        $this->material = Cache::remember('shop_filters.material', 3600, function () {
            return ProductOption::where('name', 'Material')->first()?->values ?? [];
        });

        $this->tags = Cache::remember('shop_filters.tags', 3600, function () {
            return Tag::all();
        });

        // Restore previous search and sort from session when URL is not present
        $this->sort = $this->sort ?: session('shop_sort', '');
        $this->search = $this->search ?: session('shop_search', '');

        $storedFilters = session('shop_filters', []);
        $this->appliedCategories = $this->appliedCategories ?: ($storedFilters['categories'] ?? []);
        $this->appliedSizes = $this->appliedSizes ?: ($storedFilters['sizes'] ?? []);
        $this->appliedColors = $this->appliedColors ?: ($storedFilters['colors'] ?? []);
        $this->appliedMaterial = $this->appliedMaterial ?: ($storedFilters['material'] ?? []);
        $this->appliedMinPrice = $this->appliedMinPrice ?: ($storedFilters['minPrice'] ?? '');
        $this->appliedMaxPrice = $this->appliedMaxPrice ?: ($storedFilters['maxPrice'] ?? '');

        // Sync selected with applied filters
        $this->selectedCategories = $this->appliedCategories;
        $this->selectedSizes = $this->appliedSizes;
        $this->selectedColors = $this->appliedColors;
        $this->selectedMaterial = $this->appliedMaterial;
        $this->minPrice = $this->appliedMinPrice;
        $this->maxPrice = $this->appliedMaxPrice;
    }

    public function updatedSort()
    {
        session(['shop_sort' => $this->sort]);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        session(['shop_search' => $this->search]);
        $this->resetPage();
    }

    public function toggleCategory($categoryId)
    {
        $categoryId = (int) $categoryId;
        
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_values(array_diff($this->selectedCategories, [$categoryId]));
        } else {
            $this->selectedCategories[] = $categoryId;
        }
        
    }

    public function toggleSize($size)
    {
        if (in_array($size, $this->selectedSizes)) {
            $this->selectedSizes = array_values(array_diff($this->selectedSizes, [$size]));
        } else {
            $this->selectedSizes[] = $size;
        }
        
    }

    public function toggleColor($color)
    {
        if (in_array($color, $this->selectedColors)) {
            $this->selectedColors = array_values(array_diff($this->selectedColors, [$color]));
        } else {
            $this->selectedColors[] = $color;
        }
        
    }

    public function toggleMaterial($material)
    {
        if (in_array($material, $this->selectedMaterial)) {
            $this->selectedMaterial = array_values(array_diff($this->selectedMaterial, [$material]));
        } else {
            $this->selectedMaterial[] = $material;
        }
    }

    public function applyFilters()
    {
        // Sync applied from selected
        $this->appliedCategories = $this->selectedCategories;
        $this->appliedSizes = $this->selectedSizes;
        $this->appliedColors = $this->selectedColors;
        $this->appliedMaterial = $this->selectedMaterial;
        $this->appliedMinPrice = $this->minPrice;
        $this->appliedMaxPrice = $this->maxPrice;

        session(['shop_filters' => [
            'categories' => $this->selectedCategories,
            'sizes' => $this->selectedSizes,
            'colors' => $this->selectedColors,
            'material' => $this->selectedMaterial,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
        ]]);
        
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->selectedCategories = [];
        $this->selectedSizes = [];
        $this->selectedColors = [];
        $this->selectedMaterial = [];
        $this->minPrice = '';
        $this->maxPrice = '';
        
        $this->appliedCategories = [];
        $this->appliedSizes = [];
        $this->appliedColors = [];
        $this->appliedMaterial = [];
        $this->appliedMinPrice = '';
        $this->appliedMaxPrice = '';
        
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        $cartService = app(CartService::class);
        $product = Product::with('variants')->find($productId);

        if (!$product) {
            $this->dispatch('toast', [
                'message' => 'Product not found.',
                'type' => 'error',
            ]);
            return;
        }

        if ($product->variants->count() > 0) {
            $this->dispatch('toast', [
                'message' => 'Please select a variant on the product page.',
                'type' => 'error',
            ]);
            return;
        }

        $result = $cartService->add($productId, null, 1);
        $this->dispatch('toast', [
            'message' => $result['message'],
            'type' => $result['status'],
        ]);

        if ($result['status'] === 'success') {
            $this->dispatch('cart-updated');
        }
    }

    public function toggleWishlist($productId)
    {
        $added = app('wishlist')->toggle($productId);
        $this->dispatch('countWish');
        $this->dispatch('toast', [
            'message' => $added ? 'Added to wishlist.' : 'Removed from wishlist.',
            'type' => 'success',
        ]);
    }

    public function showQuickView($productId)
    {
        $this->emit('showQuickModal', $productId);
    }

    public function render()
    {
        
        $query = Product::query()
            ->select('products.*')
            ->with(['media', 'prices', 'categories', 'variants.optionValues.option']);

        // CATEGORY FILTER
        if (!empty($this->appliedCategories) && is_array($this->appliedCategories)) {
            $cats = array_map('intval', $this->appliedCategories);
            $query->whereHas('categories', function ($q) use ($cats) {
                $q->whereIn('categories.id', $cats);
            });
        }

        // SIZE FILTER
        if (!empty($this->appliedSizes) && is_array($this->appliedSizes)) {
            $query->whereHas('variants.optionValues', function ($q) {
                $q->whereHas('option', function ($q2) {
                    $q2->where('name', 'Size');
                })->whereIn('value', $this->appliedSizes);
            });
        }

        // COLOR FILTER
        if (!empty($this->appliedColors) && is_array($this->appliedColors)) {
            $query->whereHas('variants.optionValues', function ($q) {
                $q->whereHas('option', function ($q2) {
                    $q2->where('name', 'Color');
                })->whereIn('value', $this->appliedColors);
            });
        }

        // MATERIAL FILTER
        if (!empty($this->appliedMaterial) && is_array($this->appliedMaterial)) {
            $query->whereHas('variants.optionValues', function ($q) {
                $q->whereHas('option', function ($q2) {
                    $q2->where('name', 'Material');
                })->whereIn('value', $this->appliedMaterial);
            });
        }

        // PRICE FILTER
        $minPrice = !empty($this->appliedMinPrice) && is_numeric($this->appliedMinPrice) ? (float) $this->appliedMinPrice : null;
        $maxPrice = !empty($this->appliedMaxPrice) && is_numeric($this->appliedMaxPrice) ? (float) $this->appliedMaxPrice : null;
        
        if ($minPrice !== null || $maxPrice !== null) {
            $query->whereHas('prices', function ($q) use ($minPrice, $maxPrice) {
                if ($minPrice !== null && $maxPrice !== null) {
                    $q->whereBetween('final_price', [$minPrice, $maxPrice]);
                } elseif ($minPrice !== null) {
                    $q->where('final_price', '>=', $minPrice);
                } else {
                    $q->where('final_price', '<=', $maxPrice);
                }
            });
        }

        // SEARCH
        if (!empty($this->search)) {
            $searchTerm = '%' . str_replace(['%', '_'], ['\%', '\_'], trim($this->search)) . '%';
            $query->where('name', 'LIKE', $searchTerm);
        }

        // Add min price for sorting
        $query->selectSub(
            ProductPrice::selectRaw('MIN(final_price)')
                ->whereColumn('product_prices.product_id', 'products.id'),
            'min_price'
        );

        // SORTING
        switch ($this->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('min_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('min_price', 'desc');
                break;
            case 'latest':
                $query->orderBy('products.created_at', 'desc');
                break;
            default:
                $query->orderBy('products.id', 'desc');
                break;
        }

        $products = $query->paginate(12);
        

        return view('livewire.web.shop-component', [
            'products' => $products,
        ])->extends('layouts.web')->section('web-content');
    }
}