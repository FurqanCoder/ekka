<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'variant_id',
        'product_name', 'product_sku', 'product_image',
        'variant_sku', 'variant_options',
        'price', 'quantity', 'discount_amount', 'total',
        'attributes',
    ];

    protected $casts = [
        'variant_options' => 'array',
        'attributes' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}

