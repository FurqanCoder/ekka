<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id', 'courier', 'tracking_number', 'label_url', 'status', 'api_response'
    ];

    protected $casts = [
        'api_response' => 'array',
    ];

    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }
}
