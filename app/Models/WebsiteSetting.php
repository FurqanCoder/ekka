<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebsiteSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'website_name',
        'website_tagline',
        'website_description',
        'logo_light',
        'logo_dark',
        'favicon',
        'logo_alt_text',
        'email',
        'phone',
        'whatsapp',
        'address',
        'location_url',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'pinterest',
        'tiktok',
        'github',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'primary_color',
        'secondary_color',
        'dark_mode',
        'footer_text',
        'copyright_text',
        'show_powered_by',
        'google_analytics',
        'custom_css',
        'custom_js',
        'head_scripts',
        'body_scripts',
        'is_maintenance',
        'maintenance_message',
        'allow_registration',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'show_powered_by' => 'boolean',
        'is_maintenance' => 'boolean',
        'allow_registration' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the logo URL attribute (light).
     */
    public function getLogoLightUrlAttribute(): ?string
    {
        if (empty($this->logo_light)) {
            return null;
        }
        
        if (filter_var($this->logo_light, FILTER_VALIDATE_URL)) {
            return $this->logo_light;
        }
        
        return Storage::disk('public')->url($this->logo_light);
    }

    /**
     * Get the logo URL attribute (dark).
     */
    public function getLogoDarkUrlAttribute(): ?string
    {
        if (empty($this->logo_dark)) {
            return null;
        }
        
        if (filter_var($this->logo_dark, FILTER_VALIDATE_URL)) {
            return $this->logo_dark;
        }
        
        return Storage::disk('public')->url($this->logo_dark);
    }

    /**
     * Get the favicon URL attribute.
     */
    public function getFaviconUrlAttribute(): ?string
    {
        if (empty($this->favicon)) {
            return null;
        }
        
        if (filter_var($this->favicon, FILTER_VALIDATE_URL)) {
            return $this->favicon;
        }
        
        return Storage::disk('public')->url($this->favicon);
    }

    /**
     * Get the OG image URL attribute.
     */
    public function getOgImageUrlAttribute(): ?string
    {
        if (empty($this->og_image)) {
            return null;
        }
        
        if (filter_var($this->og_image, FILTER_VALIDATE_URL)) {
            return $this->og_image;
        }
        
        return Storage::disk('public')->url($this->og_image);
    }

    /**
     * Get all social links as an array.
     */
    public function getSocialLinksAttribute(): array
    {
        return [
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'linkedin' => $this->linkedin,
            'pinterest' => $this->pinterest,
            'tiktok' => $this->tiktok,
            'github' => $this->github,
        ];
    }

    /**
     * Get active social links (non-empty).
     */
    public function getActiveSocialLinksAttribute(): array
    {
        return array_filter($this->social_links, function ($value) {
            return !empty($value);
        });
    }

    /**
     * Get meta tags for the website.
     */
    public function getMetaTagsAttribute(): array
    {
        return [
            'title' => $this->meta_title ?? $this->website_name,
            'description' => $this->meta_description ?? $this->website_description,
            'keywords' => $this->meta_keywords,
            'og_image' => $this->og_image_url,
        ];
    }

    /**
     * Get the website settings as a singleton.
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'website_name' => config('app.name', 'My Website'),
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'dark_mode' => 'auto',
            'show_powered_by' => true,
            'allow_registration' => true,
        ]);
    }

    /**
     * Get contact information as an array.
     */
    public function getContactInfoAttribute(): array
    {
        return [
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'address' => $this->address,
            'location_url' => $this->location_url,
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::updating(function ($settings) {
            // Delete old logo files if they are being replaced
            $logoFields = ['logo_light', 'logo_dark', 'favicon', 'og_image'];
            
            foreach ($logoFields as $field) {
                if ($settings->isDirty($field)) {
                    $oldValue = $settings->getOriginal($field);
                    if ($oldValue && !filter_var($oldValue, FILTER_VALIDATE_URL)) {
                        Storage::disk('public')->delete($oldValue);
                    }
                }
            }
        });
    }
}