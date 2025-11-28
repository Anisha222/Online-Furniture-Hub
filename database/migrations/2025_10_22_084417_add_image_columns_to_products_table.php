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
            // Check if columns exist before adding to prevent errors on re-run
            if (!Schema::hasColumn('products', 'image1')) {
                $table->string('image1')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'image2')) {
                $table->string('image2')->nullable()->after('image1');
            }
            if (!Schema::hasColumn('products', 'image3')) {
                $table->string('image3')->nullable()->after('image2');
            }
            if (!Schema::hasColumn('products', 'image4')) {
                $table->string('image4')->nullable()->after('image3');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image1', 'image2', 'image3', 'image4']);
        });
    }
};