<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'code',
        'discount_type',
        'discount_value',
        'usage_limit',
        'per_user_limit',
        'used_count',
        'used_by',
        'used_at',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'used_at'   => 'datetime',
        'start_date'=> 'datetime',
        'end_date'  => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired' ||
               ($this->end_date && now()->gt($this->end_date));
    }

    public function markUsed(int $userId = null): void
    {
        $this->update([
            'used_by' => $userId ?? Auth::id(),
            'used_at' => now(),
            'status'  => 'used',
            'used_count' => $this->used_count + 1,
        ]);
    }

    public function canBeUsedBy($user): bool
    {
        if ($this->isExpired() || $this->isUsed()) {
            return false;
        }

        // Check per-user limit
        if ($this->per_user_limit) {
            $userUses = self::where('code', $this->code)
                ->where('used_by', $user->id)
                ->count();

            if ($userUses >= $this->per_user_limit) {
                return false;
            }
        }

        // Check total limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }
    public function isActiveForNow(): bool
{
    $now = now();

    if ($this->status !== 'active') {
        return false;
    }

    return (!$this->start_date || $this->start_date <= $now)
        && (!$this->end_date || $this->end_date >= $now);
}

}
