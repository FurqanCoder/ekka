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
        Schema::create('carts', function (Blueprint $table) {
        $table->id();
        // Cart belongs to a user
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // Product and optional variant
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->foreignId('variant_id')->nullable()->constrained('product_variants')->cascadeOnDelete();
        // Quantity and pricing
        $table->unsignedInteger('quantity')->default(1);
        $table->timestamps();
        // Prevent duplicate product+variant rows for same user
        $table->unique(['user_id', 'product_id', 'variant_id'], 'user_product_variant_unique');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
