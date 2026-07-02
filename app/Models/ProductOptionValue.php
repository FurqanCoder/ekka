<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $fillable = ['product_option_id','value','color_code'];

    public function option()
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id');
    }

    // Which variants use this option value
    public function variants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'product_variant_values',
            'product_option_value_id',
            'product_variant_id'
        );
    }

    public function variantValues()
    {
        return $this->hasMany(ProductVariantValue::class, 'product_option_value_id');
    }
}
