<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;
    protected $fillable =[
        'shipping_zone_id','name','type', 'cost', 'estimated_days', 'is_default','status'
    ];
    public function zone()
{
    return $this->belongsTo(ShippingZone::class, 'shipping_zone_id');
}

}
