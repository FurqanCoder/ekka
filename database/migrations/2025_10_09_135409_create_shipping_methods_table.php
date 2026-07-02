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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_zone_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name'); // e.g. "Standard Delivery", "TCS Express"
            $table->enum('type', ['flat_rate', 'free', 'courier_api'])->default('flat_rate');
            $table->decimal('cost', 10, 2)->default(0);
            $table->string('estimated_days')->nullable(); // "1-3 days"
            $table->boolean('is_default')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
