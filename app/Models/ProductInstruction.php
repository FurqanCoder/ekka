<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInstruction extends Model
{
    use HasFactory;
    protected $fillable =['product_id','content', 'type', 'file_path','url'];
}
