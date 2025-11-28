<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('orderItems.product')->latest()->get();
        return view('user.order.orders', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('orderItems.product');
        // --- CHANGE THIS LINE ---
        // Change 'user.orders.show' to 'user.order.show' to match your 'user/order' folder
        return view('user.order.show', compact('order')); // <--- CORRECTED LINE
    }

    // ... (rest of your controller code remains the same)
    /**
     * Show the checkout form with cart details.
     */
    public function checkoutForm()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $cartItems = collect();
        $totalAmount = 0;

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        if ($cart) {
            $cartItems = $cart->cartItems()->with('product')->get();

            foreach ($cartItems as $item) {
                if ($item->product) {
                    $totalAmount += $item->quantity * $item->product->price;
                }
            }
        }

        return view('user.checkout.form', compact('cartItems', 'totalAmount', 'user', 'cart'));
    }

    /**
     * Place the order from the cart.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Your cart is empty and cannot be checked out.');
        }

        $cartItems = $cart->cartItems()->with('product')->get();

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            if (!$item->product) {
                return redirect()->back()->with('error', 'One or more products in your cart are no longer available. Please review your cart.');
            }
            $totalAmount += $item->quantity * $item->product->price;
        }

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => 'Pay on WhatsApp',
            'customer_name' => $request->full_name,
            'customer_phone' => $request->phone_number,
            'shipping_address' => $request->shipping_address,
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'product_price' => $cartItem->product->price,
                'price' => $cartItem->product->price,
                'product_name' => $cartItem->product->name,
            ]);
            $cartItem->delete();
        }

        $cart->delete();

        return redirect()->route('user.order.confirmation', $order)->with('success', 'Your order has been placed successfully! We will contact you via WhatsApp.');
    }

    /**
     * Show the order confirmation page.
     */
    public function confirmation(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('orderItems.product');
        return view('user.checkout.confirmation', compact('order'));
    }
}