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
use Illuminate\Support\Facades\Log;

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
        // Load options
        $this->categories = Category::with('children')->whereNull('parent_id')->get();
        $this->sizes = ProductOption::where('name', 'Size')->first()?->values ?? [];
        $this->colors = ProductOption::where('name', 'Color')->first()?->values ?? [];
        $this->material = ProductOption::where('name', 'Material')->first()?->values ?? [];
        $this->tags = Tag::all();

        // Sync selected with applied (from URL)
        $this->selectedCategories = $this->appliedCategories;
        $this->selectedSizes = $this->appliedSizes;
        $this->selectedColors = $this->appliedColors;
        $this->selectedMaterial = $this->appliedMaterial;
        $this->minPrice = $this->appliedMinPrice;
        $this->maxPrice = $this->appliedMaxPrice;
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
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
        
        Log::info('Category toggled', [
            'categoryId' => $categoryId,
            'selectedCategories' => $this->selectedCategories
        ]);
    }

    public function toggleSize($size)
    {
        if (in_array($size, $this->selectedSizes)) {
            $this->selectedSizes = array_values(array_diff($this->selectedSizes, [$size]));
        } else {
            $this->selectedSizes[] = $size;
        }
        
        Log::info('Size toggled', [
            'size' => $size,
            'selectedSizes' => $this->selectedSizes
        ]);
    }

    public function toggleColor($color)
    {
        if (in_array($color, $this->selectedColors)) {
            $this->selectedColors = array_values(array_diff($this->selectedColors, [$color]));
        } else {
            $this->selectedColors[] = $color;
        }
        
        Log::info('Color toggled', [
            'color' => $color,
            'selectedColors' => $this->selectedColors
        ]);
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
        
        Log::info('Filters applied', [
            'appliedCategories' => $this->appliedCategories,
            'appliedSizes' => $this->appliedSizes,
            'appliedColors' => $this->appliedColors,
            'appliedMinPrice' => $this->appliedMinPrice,
            'appliedMaxPrice' => $this->appliedMaxPrice,
        ]);
        
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

    public function render()
    {
        Log::info('Rendering with filters', [
            'appliedCategories' => $this->appliedCategories,
            'appliedSizes' => $this->appliedSizes,
            'appliedColors' => $this->appliedColors,
        ]);
        
        $query = Product::query()
            ->select('products.*')
            ->with(['media', 'prices', 'categories', 'variants.optionValues.option']);

        // CATEGORY FILTER
        if (!empty($this->appliedCategories) && is_array($this->appliedCategories)) {
            $cats = array_map('intval', $this->appliedCategories);
            $query->whereHas('categories', function ($q) use ($cats) {
                $q->whereIn('categories.id', $cats);
            });
            Log::info('Category filter applied', ['categories' => $cats]);
        }

        // SIZE FILTER
        if (!empty($this->appliedSizes) && is_array($this->appliedSizes)) {
            $query->whereHas('variants.optionValues', function ($q) {
                $q->whereHas('option', function ($q2) {
                    $q2->where('name', 'Size');
                })->whereIn('value', $this->appliedSizes);
            });
            Log::info('Size filter applied', ['sizes' => $this->appliedSizes]);
        }

        // COLOR FILTER
        if (!empty($this->appliedColors) && is_array($this->appliedColors)) {
            $query->whereHas('variants.optionValues', function ($q) {
                $q->whereHas('option', function ($q2) {
                    $q2->where('name', 'Color');
                })->whereIn('value', $this->appliedColors);
            });
            Log::info('Color filter applied', ['colors' => $this->appliedColors]);
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
            Log::info('Price filter applied', ['min' => $minPrice, 'max' => $maxPrice]);
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
        
        Log::info('Products found', ['count' => $products->total()]);

        return view('livewire.web.shop-component', [
            'products' => $products,
        ])->extends('layouts.web')->section('web-content');
    }
}