<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
             $table->id();
            
            // Basic Information
            $table->string('website_name')->nullable();
            $table->string('website_tagline')->nullable();
            $table->text('website_description')->nullable();
            
            // Logo Settings
            $table->string('logo_light')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo_alt_text')->nullable();
            
            // Contact Information
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();
            $table->string('location_url')->nullable();
            
            // Social Links
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('github')->nullable();
            
            // SEO Settings
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            
            // Theme Settings
            $table->string('primary_color')->default('#007bff');
            $table->string('secondary_color')->default('#6c757d');
            $table->string('dark_mode')->default('auto');
            
            // Footer Settings
            $table->string('footer_text')->nullable();
            $table->string('copyright_text')->nullable();
            $table->boolean('show_powered_by')->default(true);
            
            // Analytics & Scripts
            $table->text('google_analytics')->nullable();
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
            $table->text('head_scripts')->nullable();
            $table->text('body_scripts')->nullable();
            
            // Maintenance & Status
            $table->boolean('is_maintenance')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->boolean('allow_registration')->default(true);
            
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
