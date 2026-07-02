<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id', 'cost_price', 'base_price', 'discount_type', 'discount_value', 'tax_class', 'vat_percent', 'final_price', 'assuming_profit',
    ];
}
