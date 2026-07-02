<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image',
        'status',
        'meta_title',
        'meta_description',
    ];
      // Automatically set slug if not provided
    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /** Parent Category */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /** Child Categories */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
    /** Example relation if you attach products later */
    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }

    /** Accessors for SEO fallback */
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->name;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->description;
    }

}
