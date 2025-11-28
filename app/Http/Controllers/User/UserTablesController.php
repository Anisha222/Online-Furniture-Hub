<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class UserTablesController extends Controller
{
    public function index()
    {
        // Find the 'Tables' category by its name (case-insensitive for robustness)
        $category = Category::where('name', 'Tables')->first();

        $products = collect(); // Initialize an empty collection

        if ($category) {
            // If the category exists, retrieve its products, eager load category for good measure
            $products = Product::where('category_id', $category->id)->latest()->get();
        }

        // Pass the products to the 'user.tables' view
        return view('user.tables', compact('products'));
    }

    // You would add similar methods for Dining, Sofa, Beds, etc.
    // For example:
    public function dining()
    {
        $category = Category::where('name', 'Dining')->first();
        $products = collect();
        if ($category) {
            $products = Product::where('category_id', $category->id)->latest()->get();
        }
        return view('user.dining', compact('products')); // Assuming user/dining.blade.php exists
    }

    // public function sofa() { ... }
    // public function beds() { ... }
}