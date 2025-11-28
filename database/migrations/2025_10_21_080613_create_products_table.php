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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique();  // Unique product identifier like PRD-XXXXXX
            $table->string('name');                  // Product name
            $table->decimal('price', 8, 2);          // Price with 8 digits total, 2 decimal places
            $table->foreignId('category_id')         // Foreign key to categories table
                  ->constrained('categories')
                  ->onDelete('cascade');             // Delete products if category is deleted
            $table->text('description')->nullable(); // Product description (optional)
            $table->string('image1')->nullable();    // First product image
            $table->string('image2')->nullable();    // Second product image
            $table->string('image3')->nullable();    // Third product image
            $table->string('image4')->nullable();    // Fourth product image
            $table->timestamps();                    // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};