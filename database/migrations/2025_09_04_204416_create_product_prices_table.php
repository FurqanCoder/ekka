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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('base_price', 10, 2)->default(0);
            $table->enum('discount_type', ['none', 'percent', 'fixed'])->default('none');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->enum('tax_class', ['tax_free', 'taxable', 'digital'])->default('taxable');
            $table->decimal('vat_percent', 5, 2)->default(0);
            $table->decimal('final_price', 10, 2)->default(0);
            $table->decimal('assuming_profit', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
