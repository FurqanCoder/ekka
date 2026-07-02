<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','regions','status'
    ];
    protected $casts = [
    'regions' => 'array',
];

    public function methods()
{
    return $this->hasMany(ShippingMethod::class, 'shipping_zone_id');
}

}
