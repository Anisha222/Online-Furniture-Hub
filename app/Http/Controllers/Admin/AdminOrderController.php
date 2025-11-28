<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // Make sure your Order model is correctly referenced
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // For status validation
use App\Models\User; // Import the User model to find the admin user (good practice)

class AdminOrderController extends Controller
{
    /**
     * Display a listing of all orders for admin, excluding those made by an 'admin' user.
     * This will load the 'resources/views/admin/orders/view_order.blade.php' file.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Start a query for orders and eager load relationships
        $query = Order::with(['user', 'orderItems.product']);

        // Exclude orders placed by a user whose name is 'admin'
        // This assumes 'admin' is a user name in your 'users' table
        $query->whereDoesntHave('user', function ($q) {
            $q->where('name', 'admin');
        });

        // Optional: If you also want to explicitly include orders that might not have an associated user
        // (e.g., guest orders where user_id is NULL), uncomment the line below.
        // $query->orWhereNull('user_id');

        // Order by latest and paginate
        $orders = $query->latest()->paginate(10);

        // This will now display any success/error messages after a redirect from updateStatus
        return view('admin.orders.view_order', compact('orders'));
    }

    /**
     * Display the specified order details for admin.
     * This will load the 'resources/views/admin/orders/show.blade.php' file.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Eager load related data for the specific order
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of a specific order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in(['Pending', 'Seen', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled'])],
        ]);

        $order->status = $request->status;
        $order->save();

        // Redirect to the index page (view_order.blade.php) with a success message
        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order status for #' . $order->id . ' updated successfully to "' . $order->status . '"!');
    }
}