<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'label',
        'name',
        'phone',
        'country',
        'province',
        'city',
        'postal_code',
        'address_line_1',
        'address_line_2',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Full single-line representation for UI.
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->province,
            $this->postal_code,
            $this->country,
        ];

        return collect($parts)->filter()->implode(', ');
    }
}
