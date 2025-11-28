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
        Schema::table('products', function (Blueprint $table) {
            // Drop individual image columns if they exist
            if (Schema::hasColumn('products', 'image1')) {
                $table->dropColumn(['image1', 'image2', 'image3', 'image4']);
            }

            // Add the 'images' JSON column if it doesn't exist
            if (!Schema::hasColumn('products', 'images')) {
                $table->json('images')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert by dropping 'images' column if it exists
            if (Schema::hasColumn('products', 'images')) {
                $table->dropColumn('images');
            }

            // You might want to re-add individual image columns here if reversing completely
            // But usually, you don't reverse complex schema changes in production.
            // For development, if you need to go back, you might manually add them.
            // For now, we'll just drop the 'images' column on down.
        });
    }
};