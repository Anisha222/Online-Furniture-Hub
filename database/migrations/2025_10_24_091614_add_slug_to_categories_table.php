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
        // Check if the 'slug' column already exists before adding it
        if (!Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('slug')->unique()->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the 'slug' column exists before dropping it
        if (Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};