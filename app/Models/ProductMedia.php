<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id', 'file_path', 'type', 'is_thumbnail', 'sort_order', 'public_id'
    ];
}
