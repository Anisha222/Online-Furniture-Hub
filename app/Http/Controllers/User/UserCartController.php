<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class UserCartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->firstOrCreate(['user_id' => $user->id]);
        
        // This line correctly eager loads the product relationship
        $cartItems = $cart->cartItems()->with('product')->get();

        $total = 0;
        foreach ($cartItems as $item) {
            if ($item->product) { // Ensure product exists before accessing its properties
                $total += $item->quantity * $item->product->price;
            }
        }

        // --- IMPORTANT DEBUGGING STEP ---
        // Uncomment the line below to inspect the data being sent to your view.
        // After inspecting, REMOVE or COMMENT OUT this line before deploying.
        // dd($cartItems); 
        // --------------------------------

        // Ensure these variables are passed to the view
        return view('user.cart.index', compact('cart', 'cartItems', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $product = Product::find($request->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $product->price, // This was the crucial fix for price in cart item
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ensure the cart item belongs to the authenticated user's cart
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function removeFromCart(CartItem $cartItem)
    {
        // Ensure the cart item belongs to the authenticated user's cart
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}