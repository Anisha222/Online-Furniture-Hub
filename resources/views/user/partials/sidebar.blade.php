<!-- resources/views/user/partials/sidebar.blade.php -->
<aside class="fixed top-0 left-0 w-64 h-screen bg-gray-900 text-white flex flex-col shadow-lg">
    <!-- Sidebar Header -->
    <div class="p-5 text-center text-2xl font-semibold border-b border-gray-700">
        Furniture Shopping
    </div>

    <!-- Sidebar Menu -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <!-- Home -->
        <a href="{{ route('user.dashboard') }}"
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-home w-6 text-gray-400"></i>
            <span class="ml-2">Home</span>
        </a>

        <!-- My Profile -->
        <a href="{{ route('user.profile.edit') }}"
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-user w-6 text-gray-400"></i>
            <span class="ml-2">My Profile</span>
        </a>

        <!-- My Orders -->
        <a href="{{ route('user.orders.index') }}"
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-receipt w-6 text-gray-400"></i>
            <span class="ml-2">My Orders</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('user.cart.index') }}" {{-- CORRECTED: Changed 'user.cart' to 'user.cart.index' --}}
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-shopping-cart w-6 text-gray-400"></i>
            <span class="ml-2">Cart</span>
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-700 my-2"></div>

        <!-- Shop by Category -->
        <div class="p-3 text-sm font-semibold text-gray-400">Shop by Category</div>

        <!-- Tables -->
        {{-- If 'Tables' is a specific page, keep this. If it's a category, consider changing to category.products --}}
        <a href="{{ route('user.tables') }}"
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-chair w-6 text-blue-300"></i>
            <span class="ml-2">Tables</span>
        </a>

        <!-- Wardrobe -->
        <a href="{{ route('user.category.products', ['category' => 'wardrobe']) }}" {{-- CORRECTED: Using generic category route with slug --}}
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-door-closed w-6 text-indigo-300"></i>
            <span class="ml-2">Wardrobe</span>
        </a>

        <!-- Dining -->
        <a href="{{ route('user.category.products', ['category' => 'dining']) }}" {{-- CORRECTED: Using generic category route with slug --}}
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-utensils w-6 text-green-300"></i>
            <span class="ml-2">Dining</span>
        </a>

        <!-- Sofa -->
        <a href="{{ route('user.category.products', ['category' => 'sofa']) }}" {{-- CORRECTED: Using generic category route with slug --}}
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-couch w-6 text-purple-300"></i>
            <span class="ml-2">Sofa</span>
        </a>

        <!-- Beds -->
        <a href="{{ route('user.category.products', ['category' => 'beds']) }}" {{-- CORRECTED: Using generic category route with slug --}}
           class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-bed w-6 text-red-300"></i>
            <span class="ml-2">Beds</span>
        </a>

        <!-- Divider Line -->
        <div class="border-t border-gray-700 my-2"></div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center p-3 rounded-lg hover:bg-gray-700 transition text-left">
                <i class="fas fa-sign-out-alt w-6 text-red-400"></i>
                <span class="ml-2">Logout</span>
            </button>
        </form>
    </nav>
</aside>