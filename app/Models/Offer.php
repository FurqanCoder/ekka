<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'discount_type',
        'discount_value',
        'min_cart_amount',
        'max_discount',
        'applies_to',
        'first_order_only',
        'loyalty_points_needed',
        'stackable',
        'usage_limit',
        'per_user_limit',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'applies_to'       => 'array',
        'first_order_only' => 'boolean',
        'stackable'        => 'boolean',
        'status'           => 'boolean',
        'start_date'       => 'datetime',
        'end_date'         => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
public function scopeActive($query)
{
   // $now = now(); // Laravel app timezone (Asia/Karachi)
    
    return $query->where('status', true);
        // ->where(function ($q) use ($now) {
        //     $q->whereNull('start_date')
        //       ->orWhere('start_date', '<=', $now);
        // })
        // ->where(function ($q) use ($now) {
        //     $q->whereNull('end_date')
        //       ->orWhere('end_date', '>=', $now);
        // });
}
public function isActive(): bool
{
    return $this->status && $this->isWithinDateRange();
}

public function isWithinDateRange(): bool
{
    $now = now();
    return (!$this->start_date || $this->start_date <= $now) &&
           (!$this->end_date || $this->end_date >= $now);
}



    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    // public function isActive(): bool
    // {
    //     return $this->status &&
    //         (is_null($this->start_date) || now()->gte($this->start_date)) &&
    //         (is_null($this->end_date) || now()->lte($this->end_date));
    // }

    public function isExpired(): bool
    {
        return $this->end_date && now()->gt($this->end_date);
    }

    public function isApplicableToProduct($productId): bool
    {
        return $this->type === 'product'
            && in_array($productId, $this->applies_to ?? []);
    }

    public function isApplicableToCategory($categoryId): bool
    {
        return $this->type === 'category'
            && in_array($categoryId, $this->applies_to ?? []);
    }
}
