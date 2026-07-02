<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Brand extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'name', 'slug', 'description','logo','public_id', 'status','meta_title','meta_description','meta_keywords'
    ];
    protected static function booted()
    {
        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
