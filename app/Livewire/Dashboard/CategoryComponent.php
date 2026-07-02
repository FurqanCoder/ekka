<?php

namespace App\Livewire\Dashboard;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Cloudinary\Api\Exception\ApiError;
use Illuminate\Support\Facades\Log;

class CategoryComponent extends Component
{
    use WithFileUploads;

    public $categories;
    public $category_id;

    public $categoryName;
    public $description;
    public $image;
    public $parent;
    public $metaTitle;
    public $metaDescription;

    public $button = 'Create Category';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::with('children:id,parent_id,name')
            ->withCount('children')
            ->get();
    }

    public function toggle($id)
    {
        $cat = Category::find($id);
        if ($cat) {
            $cat->status = $cat->status === 'active' ? 'inactive' : 'active';
            $cat->save();
            $this->loadCategories();
            $this->dispatch('toast', 'Category status updated successfully!', 'info');
        } else {
            $this->dispatch('toast', 'Category not found!', 'error');
        }
    }

    public function addCategory()
    {
        $this->validate([
            'categoryName'     => 'required|string|max:255|unique:categories,name,' . $this->category_id,
            'description'      => 'required|string|max:255',
            'image'            => 'nullable|image|max:2048',
            'parent'           => 'nullable|exists:categories,id',
        ]);

        $category = $this->category_id
            ? Category::findOrFail($this->category_id)
            : new Category();

        $category->name = $this->categoryName;
        $category->description = $this->description;
        $category->slug = Str::slug($this->categoryName);
        $category->parent_id = $this->parent;
        $category->meta_title = $this->metaTitle;
        $category->meta_description = $this->metaDescription;

        // ✅ Handle Cloudinary image
        if ($this->image && !is_string($this->image)) {
            $cloudinary = app('cloudinary.account.one');

            // If updating and category already has an image, delete old one
            if ($category->public_id) {
                try {
                    $cloudinary->uploadApi()->destroy($category->public_id);
                } catch (ApiError $e) {
                    Log::error("Cloudinary delete failed (update): " . $e->getMessage());
                }
            }

            $uploadResult = $cloudinary->uploadApi()->upload(
                $this->image->getRealPath(),
                [
                    'folder' => 'categories',
                    'resource_type' => 'image',
                ]
            );

            $result = $uploadResult->getArrayCopy();

            $category->image = $result['secure_url'];
            $category->public_id = $result['public_id'];
        }

        $category->save();

        $this->resetForm();
        $this->loadCategories();
        $this->dispatch('toast', 'Category saved successfully!', 'success');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->category_id = $id;
        $this->categoryName = $category->name;
        $this->description = $category->description;
        $this->image = $category->image; // URL only
        $this->parent = $category->parent_id;
        $this->metaTitle = $category->meta_title;
        $this->metaDescription = $category->meta_description;
        $this->button = 'Update Category';

        $this->dispatch('open-modal');
    }

    public function delete($id)
    {
        if ($category = Category::find($id)) {
            if ($category->public_id) {
                try {
                    $cloudinary = app('cloudinary.account.one');
                    $cloudinary->uploadApi()->destroy($category->public_id);
                } catch (ApiError $e) {
                    Log::error("Cloudinary delete failed (delete): " . $e->getMessage());
                }
            }

            $category->delete();
            $this->loadCategories();
            $this->dispatch('toast', 'Category deleted successfully!', 'info');
        } else {
            $this->dispatch('toast', 'Category not found!', 'error');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'category_id',
            'categoryName',
            'description',
            'image',
            'parent',
            'metaTitle',
            'metaDescription',
        ]);
        $this->button = 'Create Category';
    }

    public function open()
    {
        $this->dispatch('open-modal');
    }

    public function render()
    {
        return view('livewire.dashboard.category-component', [
            'categories' => $this->categories,
        ])->extends('layouts.admin')->section('admin-content');
    }
}
