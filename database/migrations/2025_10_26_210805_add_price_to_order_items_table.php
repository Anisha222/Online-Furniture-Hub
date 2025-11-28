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
        Schema::table('order_items', function (Blueprint $table) {
            // Add 'price' column as a decimal, allowing 10 total digits with 2 decimal places.
            // It should be nullable or have a default if you have existing order items without a price.
            // Placing it after 'quantity' is a good practice.
            if (!Schema::hasColumn('order_items', 'price')) { // Safety check
                $table->decimal('price', 10, 2)->after('quantity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the 'price' column if rolling back
            if (Schema::hasColumn('order_items', 'price')) { // Safety check
                $table->dropColumn('price');
            }
        });
    }
};