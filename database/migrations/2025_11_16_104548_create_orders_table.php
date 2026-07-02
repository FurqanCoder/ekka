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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // User
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Address Snapshot
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('country')->default('Pakistan');

            // Shipping method
            $table->foreignId('shipping_method_id')->nullable()->constrained('shipping_methods')->nullOnDelete();
            $table->string('shipping_method_name')->nullable();
            $table->string('tracking_no')->nullable();

            // Payment Info
            $table->string('payment_method'); // cod, card, jazzcash, easypaisa
            $table->string('payment_status')->default('pending'); // pending, paid, failed, refunded
            $table->string('transaction_id')->nullable();

            // Offers & Coupons
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->string('coupon_code')->nullable();
            $table->foreignId('offer_id')->nullable()->constrained()->nullOnDelete();

            // Amounts
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_charges', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);
            $table->integer('total_items')->default(0);
            $table->string('currency')->default('PKR');

            // Status
            $table->string('status')->default('pending');
            // pending, confirmed, processing, shipped, delivered, cancelled, returned

            // Admin notes / customer notes
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();

            // Invoice
            $table->string('invoice_no')->unique();
            $table->dateTime('invoice_date')->nullable();

            // Refund
            $table->boolean('is_refunded')->default(false);
            $table->decimal('refunded_amount', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
