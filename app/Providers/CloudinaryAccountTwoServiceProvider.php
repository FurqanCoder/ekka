<?php

namespace App\Providers;

use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class CloudinaryAccountTwoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (env('CLOUDINARY_CLOUD_NAME_2') && env('CLOUDINARY_API_KEY_2') && env('CLOUDINARY_API_SECRET_2')) {
            $this->app->singleton('cloudinary.account.two', function ($app) {
                return new Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME_2'),
                        'api_key'    => env('CLOUDINARY_API_KEY_2'),
                        'api_secret' => env('CLOUDINARY_API_SECRET_2'),
                        'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET_2'),

                    ],
                    'url' => ['secure' => true],
                ]);
            });
        } else {
            Log::error('Cloudinary Account 2: Missing environment variables');
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
