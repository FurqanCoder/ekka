<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
      //  'price',
       // 'total',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Automatically calculate total on save
    // protected static function booted()
    // {
    //     static::saving(function ($cart) {
    //         $cart->total = $cart->quantity * $cart->price;
    //     });
    // }
}
