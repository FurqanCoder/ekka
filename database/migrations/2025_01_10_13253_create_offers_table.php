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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            // Offer type
            $table->enum('type', [
                'product',
                'category',
                'cart',
                'shipping',
                'user',
                'order'
            ]);

            // Discount type
            $table->enum('discount_type', [
                'percentage',
                'fixed',
                'bogo',
                'free_shipping'
            ])->default('percentage');

            $table->decimal('discount_value', 10, 2)->nullable();
            $table->decimal('min_cart_amount', 10, 2)->nullable();
            $table->decimal('max_discount', 10, 2)->nullable();

            // Rules & Conditions
            $table->json('applies_to')->nullable(); // product_ids, category_ids, user_ids
            $table->boolean('first_order_only')->default(false);
            $table->unsignedInteger('loyalty_points_needed')->nullable();
            $table->boolean('stackable')->default(false);

            // Usage limits
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('per_user_limit')->nullable();

            // Validity
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
