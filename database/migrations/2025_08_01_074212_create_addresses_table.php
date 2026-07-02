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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('label')->nullable(); // Home, Office, etc
            $table->string('name');
            $table->string('phone', 32);
            $table->string('country', 64)->default('Pakistan'); // change if you want
            $table->string('province', 128)->nullable();
            $table->string('city', 128);
            $table->string('postal_code', 32)->nullable();
            $table->text('address_line_1');
            $table->text('address_line_2')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->index(['user_id', 'is_default']);
            $table->index(['user_id', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
