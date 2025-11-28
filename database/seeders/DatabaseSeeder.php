<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class, // Your admin and regular users
            CategorySeeder::class,  // <--- ADD THIS LINE to call the CategorySeeder
            // Add any other seeders here as you create them
            // ProductSeeder::class, // If you create a seeder for initial products
        ]);

        // You likely have commented out User::factory() calls here, keep them commented or remove them.
    }
}