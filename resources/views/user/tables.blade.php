{{-- resources/views/user/tables.blade.php --}}

@extends('layouts.app') {{-- Ensure this extends your correct user layout --}}

@section('title', 'Tables') {{-- Set the title for this specific page --}}

@section('content')
<div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar (Your existing sidebar code) -->
    <aside class="w-64 bg-black text-white h-screen fixed left-0 top-0 overflow-y-auto">
        <div class="p-4">
            <h1 class="text-xl font-bold mb-6">Furniture Shopping</h1>

            <nav class="space-y-2">
                <a href="{{ route('user.dashboard') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.dashboard') ? 'bg-gray-800' : '' }}">Home</a>
                <a href="{{ route('user.profile.edit') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.profile.edit') ? 'bg-gray-800' : '' }}">My Profile</a>
                <a href="{{ route('user.orders.index') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.orders.*') ? 'bg-gray-800' : '' }}">My Orders</a>
                <a href="{{ route('user.cart.index') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.cart.index') ? 'bg-blue-600' : '' }}">Cart</a>
                <a href="{{ route('user.tables') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('user.tables') ? 'bg-blue-600' : '' }}">Tables</a>
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
    <main class="flex-1 ml-64">
        <div class="p-6">
            <div class="max-w-4xl mx-auto"> {{-- Centered and max-width content area --}}
                <h1 class="text-2xl font-bold mb-6">Tables</h1> {{-- Heading for the category page --}}

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($products->isEmpty())
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative text-center" role="alert">
                        <p class="font-bold">No table products found at the moment.</p>
                        <p class="mt-2">Please check back later or browse other categories.</p>
                        <a href="{{ route('user.dashboard') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Continue Shopping</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"> {{-- Responsive Tailwind grid layout --}}
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition-transform duration-200 hover:scale-105 hover:shadow-lg"> {{-- Product card styling --}}
                                {{-- Link the entire card content to the product detail page (optional, based on your UX) --}}
                                {{-- <a href="{{ route('user.products.show', $product->id) }}" class="block text-decoration-none text-gray-900"> --}}
                                    {{-- Image Display Logic --}}
                                    @if ($product->image) {{-- Assuming a single 'image' column for the primary image --}}
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover p-2 bg-white" alt="{{ $product->name }}">
                                    @else
                                        {{-- Placeholder image if no image is available --}}
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">No Image</div>
                                    @endif

                                    <div class="p-4 text-center bg-white flex flex-col justify-between h-full">
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-900 mb-1">{{ $product->name }}</h5>
                                            {{-- If you want to show category: <p class="text-gray-500 text-sm mb-2">Category: {{ $product->category->name }}</p> --}}
                                            <p class="text-xl font-bold text-green-600 mb-3">Nu. {{ number_format($product->price, 0) }}</p>
                                        </div>
                                        {{-- The description is typically on the detail page, but kept if you want it --}}
                                        @if($product->description && Str::length($product->description) > 0)
                                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 50) }}</p>
                                        @endif

                                        {{-- CRITICAL CHANGE: The Add to Cart form --}}
                                        <form action="{{ route('user.cart.add') }}" method="POST" class="mt-auto">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1"> {{-- Default quantity to 1 --}}
                                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                {{-- </a> --}} {{-- End of optional link for the whole card --}}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection

{{-- Removed all @push('styles') and @push('scripts') blocks from here --}}