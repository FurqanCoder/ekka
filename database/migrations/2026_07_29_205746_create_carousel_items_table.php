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
        Schema::create('carousel_items', function (Blueprint $table) {
             $table->id();
            
            // Image fields
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            
            // Content fields
            $table->string('title')->nullable();
            $table->string('offer_label')->nullable();
            $table->string('discount_badge')->nullable();
            $table->text('description')->nullable();
            
            // Link fields
            $table->string('button_link')->nullable();
            $table->string('button_text')->default('Shop Now');
            
            // Status and ordering
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->integer('sort_order')->default(0);
            
            // Metadata
            $table->json('meta_data')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // User tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['status', 'sort_order']);
            $table->index('published_at');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousel_items');
    }
};
