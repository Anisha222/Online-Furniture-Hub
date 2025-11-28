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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Links to the carts table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Links to the products table
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2); // Store the price at the time of adding to cart
            $table->timestamps();

            // Optional: Ensure a product can only be in a cart once
            $table->unique(['cart_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};