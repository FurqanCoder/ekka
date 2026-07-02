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
        if (!Schema::hasTable('coupons')) {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->nullable()->constrained('offers')->nullOnDelete();

            $table->string('code')->unique();
            $table->enum('discount_type', [
                'percentage',
                'fixed',
                'free_shipping'
            ])->nullable(); // optional override (if not linked to offer)
            $table->decimal('discount_value', 10, 2)->nullable();

            // Usage tracking
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('per_user_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);

            // Tracking usage
            $table->foreignId('used_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('used_at')->nullable();

            // Validity
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->enum('status', ['active', 'used', 'expired'])->default('active');

            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
