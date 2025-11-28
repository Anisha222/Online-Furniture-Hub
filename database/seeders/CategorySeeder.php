<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Import the Category model
use Illuminate\Support\Str; // Import Str for slug generation

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Tables',
            'Wardrobe',
            'Dining',
            'Sofa',
            'Beds',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName], // Search for category by name
                ['slug' => Str::slug($categoryName)] // If not found, create with generated slug
            );
        }
    }
}