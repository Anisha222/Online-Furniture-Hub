<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display products for a specific category using its slug.
     * This method leverages Route Model Binding, so Laravel automatically
     * retrieves the Category instance based on the 'category' parameter in the route.
     * The Category model's getRouteKeyName() method is set to 'slug' for this to work.
     */
    public function showProductsByCategory(Category $category)
    {
        // Eager load products and their associated category to avoid N+1 queries
        $products = $category->products()->with('category')->latest()->get();

        // Pass the category object and its products to a generic category display view
        // Make sure you have resources/views/user/categories/show.blade.php
        return view('user.categories.show', compact('category', 'products'));
    }

    /*
    // The following individual methods (tables, wardrobe, etc.) are now redundant
    // because the dynamic showProductsByCategory method handles all categories.
    // I'm commenting them out, but you should ideally remove them once you confirm
    // the dynamic route and view (user.categories.show) are working correctly.

    public function tables()
    {
        $category = Category::where('name', 'Tables')->first();
        $products = collect();
        if ($category) {
            $products = Product::where('category_id', $category->id)->latest()->get();
        }
        return view('user.tables', compact('products'));
    }

    public function wardrobe()
    {
        $category = Category::where('name', 'Wardrobe')->first();
        $products = collect();
        if ($category) {
            $products = Product::where('category_id', $category->id)->latest()->get();
        }
        return view('user.wardrobe', compact('products'));
    }

    public function dining()
    {
        $category = Category::where('name', 'Dining')->first();
        $products = collect();
        if ($category) {
            $products = Product::where('category_id', $category->id)->latest()->get();
        }
        return view('user.dining', compact('products'));
    }

    public function sofa()
    {
        $category = Category::where('name', 'Sofa')->first();
        $products = collect();
        if ($category) {
            $products = Product::where('category_id', $category->id)->latest()->get();
        }
        return view('user.sofa', compact('products'));
    }

    public function beds()
    {
        $category = Category::where('name', 'Beds')->first();
        $products = collect();
        if ($category) {
            $products = Product::where('category_id', $category->id)->latest()->get();
        }
        return view('user.beds', compact('products'));
    }
    */
}