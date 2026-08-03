<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarouselItem extends Model
{
     use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_path',
        'image_alt',
        'title',
        'offer_label',
        'discount_badge',
        'description',
        'button_link',
        'button_text',
        'status',
        'sort_order',
        'meta_data',
        'published_at',
        'expires_at',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta_data' => 'array',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image_url',
        'status_color',
        'status_badge',
        'is_active',
        'is_expired',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($carouselItem) {
            if (empty($carouselItem->sort_order)) {
                $carouselItem->sort_order = self::max('sort_order') + 1;
            }
        });

        static::deleting(function ($carouselItem) {
            // Delete the image file when the record is deleted
            if ($carouselItem->image_path) {
                Storage::disk('public')->delete($carouselItem->image_path);
            }
        });
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        // Check if it's a full URL (external image)
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        // Return storage URL
        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Get the status color attribute.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'draft' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get the status badge attribute.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'active' => 'success',
            'inactive' => 'secondary',
            'draft' => 'warning',
        ];

        $color = $colors[$this->status] ?? 'secondary';
        return "<span class='badge bg-{$color}-subtle text-{$color}'>{$this->status}</span>";
    }

    /**
     * Check if the item is active.
     */
    public function getIsActiveAttribute(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->published_at && $this->published_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if the item is expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expires_at) {
            return false;
        }

        return $this->expires_at->isPast();
    }

    /**
     * Get the user who created the item.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the item.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope a query to only include items published.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Set the image path attribute.
     */
    public function setImagePathAttribute($value): void
    {
        // If it's a full URL, store as is
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $this->attributes['image_path'] = $value;
            return;
        }

        // If it's a file upload, handle it
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            $path = $value->store('carousel', 'public');
            $this->attributes['image_path'] = $path;
            return;
        }

        $this->attributes['image_path'] = $value;
    }

    /**
     * Get a URL-friendly slug for the title.
     */
    public function getSlugAttribute(): string
    {
        return $this->title ? Str::slug($this->title) : 'carousel-item-' . $this->id;
    }

    /**
     * Get formatted description (strip HTML if needed).
     */
    public function getFormattedDescriptionAttribute(): string
    {
        return strip_tags($this->description ?? '');
    }

    /**
     * Get the meta data value by key.
     */
    public function getMeta(string $key, $default = null)
    {
        return data_get($this->meta_data, $key, $default);
    }

    /**
     * Set a meta data value.
     */
    public function setMeta(string $key, $value): void
    {
        $meta = $this->meta_data ?? [];
        data_set($meta, $key, $value);
        $this->meta_data = $meta;
    }

    /**
     * Get the full URL for the item.
     */
    public function getFullUrlAttribute(): string
    {
        return route('carousel.show', $this->id) . '?slug=' . $this->slug;
    }

    /**
     * Check if the item has an image.
     */
    public function hasImage(): bool
    {
        return !empty($this->image_path);
    }

    /**
     * Delete the image file.
     */
    public function deleteImage(): bool
    {
        if (!$this->image_path) {
            return false;
        }

        if (!filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($this->image_path);
        }

        $this->update(['image_path' => null]);
        return true;
    }

    /**
     * Get the image dimensions (if stored locally).
     */
    public function getImageDimensions(): ?array
    {
        if (!$this->image_path || filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return null;
        }

        $path = Storage::disk('public')->path($this->image_path);
        if (!file_exists($path)) {
            return null;
        }

        return getimagesize($path) ?: null;
    }

    /**
     * Create a new carousel item from an array.
     */
    public static function createFromArray(array $data): self
    {
        return self::create([
            'image_path' => $data['image'] ?? null,
            'image_alt' => $data['title'] ?? null,
            'title' => $data['title'] ?? null,
            'offer_label' => $data['offer_label'] ?? null,
            'discount_badge' => $data['discount_badge'] ?? null,
            'description' => $data['description'] ?? null,
            'button_link' => $data['button_link'] ?? null,
            'button_text' => $data['button_text'] ?? 'Shop Now',
            'status' => $data['status'] ?? 'draft',
            'sort_order' => $data['sort_order'] ?? null,
            'published_at' => $data['published_at'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);
    }

    /**
     * Update the item from an array.
     */
    public function updateFromArray(array $data): self
    {
        $this->update([
            'image_path' => $data['image'] ?? $this->image_path,
            'image_alt' => $data['title'] ?? $this->image_alt,
            'title' => $data['title'] ?? $this->title,
            'offer_label' => $data['offer_label'] ?? $this->offer_label,
            'discount_badge' => $data['discount_badge'] ?? $this->discount_badge,
            'description' => $data['description'] ?? $this->description,
            'button_link' => $data['button_link'] ?? $this->button_link,
            'button_text' => $data['button_text'] ?? $this->button_text,
            'status' => $data['status'] ?? $this->status,
            'published_at' => $data['published_at'] ?? $this->published_at,
            'expires_at' => $data['expires_at'] ?? $this->expires_at,
        ]);

        return $this;
    }
}
