<?php

namespace App\Livewire\Web\Components\Global;

use App\Models\Category;
use Livewire\Component;

class CategorySidebar extends Component
{
     public $categories = [];
    public $selectedCategory = null;

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        // Load only parent categories with their children
        $this->categories = Category::with(['children' => function($query) {
            $query->where('status', 'active')
                  ->orderBy('name', 'asc');
        }])
        ->whereNull('parent_id')
        ->where('status', 'active')
        ->orderBy('name', 'asc')
        ->get()
        ->map(function($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image' => $category->image,
                'image_url' => $category->image ? asset('storage/' . $category->image) : null,
                'description' => $category->description,
                'children' => $category->children->map(function($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'slug' => $child->slug,
                        'product_count' => $child->products()->count(),
                    ];
                })->toArray(),
            ];
        })
        ->toArray();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->dispatch('categorySelected', categoryId: $categoryId);
    }
    public function render()
    {
        return view('livewire.web.components.global.category-sidebar');
    }
}
