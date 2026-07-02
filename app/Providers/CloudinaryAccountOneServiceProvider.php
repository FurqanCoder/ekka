<?php

namespace App\Providers;

use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class CloudinaryAccountOneServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (env('CLOUDINARY_CLOUD_NAME_1') && env('CLOUDINARY_API_KEY_1') && env('CLOUDINARY_API_SECRET_1')) {
            $this->app->singleton('cloudinary.account.one', function () {
                return new Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME_1'),
                        'api_key'    => env('CLOUDINARY_API_KEY_1'),
                        'api_secret' => env('CLOUDINARY_API_SECRET_1'),
                    ],
                    'url' => ['secure' => true],
                ]);
            });
        } else {
            Log::error('Cloudinary Account 1: Missing environment variables');
        }
    }
}
