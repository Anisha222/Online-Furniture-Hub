<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // Import the Category model (if needed for index or other filters)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; // Needed for Redirect::route

class ProductController extends Controller
{
    /**
     * Display a listing of all products for users.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all(); // Might be useful for a category filter on the user dashboard
        return view('user.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     * Uses Route Model Binding to automatically inject the Product instance.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Eager load the category relationship so category data is available in the view
        $product->load('category');

        return view('user.products.show', compact('product'));
    }

    /**
     * Handles adding a product to the user's cart.
     * This method now acts as a dispatcher to UserCartController for actual cart logic.
     * This centralizes cart modification logic in UserCartController.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Redirect to the UserCartController's addToCart method
        // This is where the actual cart creation/item addition logic resides.
        return Redirect::route('user.cart.add', [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ])->with('success', 'Product added to cart!');
    }

    /*
    // The showByCategory method is now handled by UserCategoryController@showProductsByCategory
    // and uses a dynamic route like /user/category/{category:slug}.
    // This method is therefore redundant and should be removed.

    public function showByCategory($categoryName)
    {
        $category = Category::where('name', $categoryName)->firstOrFail();
        $products = $category->products()->latest()->get();
        $categories = Category::all();
        return view('user.products.index', compact('products', 'category', 'categories'));
    }
    */
}