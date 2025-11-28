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
        Schema::table('users', function (Blueprint $table) {
            // Check if 'phone' column does NOT exist before adding it
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            // Check if 'address' column does NOT exist before adding it
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if 'phone' column DOES exist before dropping it
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            // Check if 'address' column DOES exist before dropping it
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};