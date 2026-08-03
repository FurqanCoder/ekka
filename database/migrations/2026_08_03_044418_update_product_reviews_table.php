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
        Schema::table('product_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('product_reviews', 'reply')) {
                $table->text('reply')->nullable()->after('review');
            }
            if (!Schema::hasColumn('product_reviews', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('reply');
            }
            if (!Schema::hasColumn('product_reviews', 'replied_by')) {
                $table->foreignId('replied_by')->nullable()->constrained('users')->nullOnDelete()->after('replied_at');
            }
            if (!Schema::hasColumn('product_reviews', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropColumn(['reply', 'replied_at', 'replied_by', 'approved_at']);
        });
    }
};
