<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'customer_name', 'customer_phone', 'customer_email',
        'shipping_address', 'shipping_city', 'shipping_state', 'shipping_postal_code',
        'country', 'shipping_method_id', 'shipping_method_name', 'tracking_no',
        'payment_method', 'payment_status', 'transaction_id',
        'coupon_id', 'coupon_code', 'offer_id',
        'subtotal', 'discount_amount', 'shipping_charges', 'tax_amount',
        'grand_total', 'total_items', 'currency',
        'status', 'customer_note', 'admin_note',
        'invoice_no', 'invoice_date', 'confirmed_at', 'shipped_at', 'delivered_at',
        'is_refunded', 'refunded_amount'
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }
//     public function items()
// {
//     return $this->hasMany(OrderItem::class);
// }

public function address()
{
    return $this->belongsTo(Address::class);
}

}

