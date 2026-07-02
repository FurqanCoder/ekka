<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id','sku','price','cost','stock','image','public_id','active'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // relationship to pivot rows
    public function values()
    {
        return $this->hasMany(ProductVariantValue::class, 'product_variant_id');
    }

    // direct access to ProductOptionValue models via pivot table
    public function optionValues()
    {
        return $this->belongsToMany(
            ProductOptionValue::class,
            'product_variant_values',
            'product_variant_id',
            'product_option_value_id'
        );
    }
}
