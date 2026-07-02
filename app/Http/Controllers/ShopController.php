<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\Tag;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        // Assuming ProductOption::first()?->values is a collection/array of unique option values
        $sizes      = ProductOption::where('name', 'Size')->first()?->values ?? [];
        $colors     = ProductOption::where('name', 'Color')->first()?->values ?? [];
        $material   = ProductOption::where('name', 'Material')->first()?->values ?? [];
        $tags       = Tag::all();

        $products = Product::with(['media', 'prices', 'variants.optionValues.option', 'categories']);

        // Filters
        if ($request->filled('categories')) {
            $products->whereHas('categories', function($q) use($request){
                // Note: $request->categories should now be a simple array of IDs
                $q->whereIn('categories.id', $request->categories);
            });
        }

        // FIX: Nested whereHas to filter by value on 'optionValues' and option name on 'option'
        if ($request->filled('sizes')) {
            $products->whereHas('variants.optionValues', function($q_optionValue) use($request){
                $q_optionValue->whereIn('value', $request->sizes)
                              ->whereHas('option', function($q_option) {
                                  $q_option->where('name', 'Size');
                              });
            });
        }

        if ($request->filled('colors')) {
            $products->whereHas('variants.optionValues', function($q_optionValue) use($request){
                $q_optionValue->whereIn('value', $request->colors)
                              ->whereHas('option', function($q_option) {
                                  $q_option->where('name', 'Color');
                              });
            });
        }

        if ($request->filled('material')) {
            $products->whereHas('variants.optionValues', function($q_optionValue) use($request){
                $q_optionValue->whereIn('value', $request->material)
                              ->whereHas('option', function($q_option) {
                                  $q_option->where('name', 'Material');
                              });
            });
        }
       
        if ($request->filled('search')) {
    // 1. Correctly retrieve the input value (using the property access shorthand)
    $searchTerm = $request->search; 
    
    // 2. Add the SQL wildcard operator (%) for partial matching
    $products->where('name', 'LIKE', '%' . $searchTerm . '%');
}
        if ($request->filled('minPrice') || $request->filled('maxPrice')) {
            // Note: If a product can have multiple prices, this WhereHas ensures at least one price
            // falls within the range. For simpler logic, ensure ProductPrice records are normalized.
            $products->whereHas('prices', function($q) use ($request) {
                if ($request->minPrice && $request->maxPrice) {
                    $q->whereBetween('final_price', [$request->minPrice, $request->maxPrice]);
                } elseif ($request->minPrice) {
                    $q->where('final_price', '>=', $request->minPrice);
                } elseif ($request->maxPrice) {
                    $q->where('final_price', '<=', $request->maxPrice);
                }
            });
        }

        // Sorting (no changes needed here, looks correct)
        switch ($request->sort) {
            case 'name_asc': $products->orderBy('name'); break;
            case 'name_desc': $products->orderBy('name','desc'); break;
            case 'price_asc':
                $products->orderBy(
                    ProductPrice::select('final_price')
                        ->whereColumn('product_id','products.id')->limit(1)
                );
                break;
            case 'price_desc':
                $products->orderBy(
                    ProductPrice::select('final_price')
                        ->whereColumn('product_id','products.id')->limit(1),
                    'desc'
                );
                break;
            case 'latest': $products->orderBy('created_at','desc'); break;
            default: $products->orderBy('id','desc');
        }

        $products = $products->paginate(12)->appends($request->query());

        // 🔥 AJAX response — return only product list
        if ($request->ajax()) {
            return view('partials.web.products', compact('products'))->render();
        }

        // Normal page load
        return view('partials.web.shop', compact(
            'products','categories','sizes','colors','material','tags'
        ));
    }
}