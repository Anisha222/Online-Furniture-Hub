<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // <--- IMPORTANT: Make sure this is imported
use App\Models\Category; // <--- IMPORTANT: Make sure this is imported (if you plan to use it here)

class UserDashboardController extends Controller
{
    // TEMPORARILY COMMENTED OUT OR REMOVED THE CONSTRUCTOR
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    /**
     * Show the user dashboard with latest products.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // --- CORRECTED: Fetch the latest products from the database ---
        // Fetch the latest products. You can adjust the limit as needed.
        // Eager load category for display purposes.
        $products = Product::with('category')->latest()->take(6)->get(); // Get the 6 latest products for the dashboard

        // Pass the user data AND the products data to the view
        return view('user.dashboard', compact('user', 'products'));
    }
}