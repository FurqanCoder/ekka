<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name','slug','description','brand_id','status','scheduled_at',
        'sku','stock','track','meta_title','meta_description','meta_keywords'
    ];
    // Automatically set slug if not provided
    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function media()
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function instructions()
    {
        return $this->hasOne(ProductInstruction::class);
    }

    public function ingredients()
    {
        return $this->hasMany(ProductIngredients::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags')->withPivot('is_featured');
    }

    public function prices()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->where('active', true);
    }
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->name;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->description;
    }
// App\Models\Product.php
public function optionValuesByName(string $optionName)
{
    return $this->variants
        ->flatMap->optionValues
        ->filter(fn($v) => $v->option && strtolower($v->option->name) === strtolower($optionName))
        ->unique('value');
}
public function reviews()
{
    return $this->hasMany(ProductReview::class);
}

public function avgRating()
{
    return $this->reviews()->avg('rating');
}

public function reviewCount()
{
    return $this->reviews()->count();
}

public function getRouteKeyName()
{
    return 'slug';
}

}
