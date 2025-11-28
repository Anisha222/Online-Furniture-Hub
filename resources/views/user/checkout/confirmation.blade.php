@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar (Keep your existing sidebar code here) -->
    <aside class="w-64 bg-black text-white h-screen fixed left-0 top-0 overflow-y-auto">
        <div class="p-4">
            <h1 class="text-xl font-bold mb-6">Furniture Shopping</h1>
            <nav class="space-y-2">
                <a href="{{ route('user.dashboard') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.dashboard') ? 'bg-gray-800' : '' }}">Home</a>
                <a href="{{ route('user.profile.edit') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.profile.edit') ? 'bg-gray-800' : '' }}">My Profile</a>
                <a href="{{ route('user.orders.index') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.orders.*') ? 'bg-gray-800' : '' }}">My Orders</a>
                <a href="{{ route('user.cart.index') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.cart.index') ? 'bg-gray-800' : '' }}">Cart</a>
                <a href="{{ route('user.tables') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.tables') ? 'bg-gray-800' : '' }}">Tables</a>
                <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-800">Wardrobe</a>
                 <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-800">Dining</a>
                 <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-800">Sofa</a>
                 <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-800">Beds</a>
                <hr class="my-4 border-gray-700">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center py-2 px-4 rounded hover:bg-gray-800">Logout</a>
            </nav>
        </div>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-6 bg-gray-100">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md text-center">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <h1 class="text-3xl font-bold text-green-600 mb-4">Order Placed Successfully!</h1>
            <p class="text-gray-700 text-lg mb-6">Your order #{{ $order->id }} has been received.</p>
            <p class="text-gray-700 mb-2">We will contact you shortly via WhatsApp to confirm your order and delivery details.</p>
            <p class="text-gray-700 mb-6">Thank you for shopping with us!</p>

            <div class="border-t border-gray-200 pt-6 mt-6 text-left">
                <h2 class="text-xl font-semibold mb-4">Order Details</h2>
                <p class="mb-2"><strong>Total Amount:</strong> Nu. {{ number_format($order->total_amount, 2) }}</p>
                <p class="mb-2"><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                <p class="mb-2"><strong>Delivery Address:</strong> {{ $order->shipping_address }}</p>
                <p class="mb-2"><strong>Contact Number:</strong> {{ $order->customer_phone }}</p>

                <h3 class="text-lg font-semibold mt-4 mb-2">Items Ordered:</h3>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($order->orderItems as $item)
                        <li>{{ $item->product->name ?? 'N/A' }} (Nu. {{ number_format($item->price, 2) }}) x {{ $item->quantity }} = Nu. {{ number_format($item->price * $item->quantity, 2) }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-8">
                <a href="{{ route('user.orders.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 mr-4">View My Orders</a>
                <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:underline px-6 py-3">Continue Shopping</a>
            </div>
        </div>
    </main>
</div>
@endsection