{{-- resources/views/layouts/user_sidebar.blade.php --}}

<div class="h-100 d-flex flex-column">
    <!-- Sidebar Header -->
    <div class="sidebar-heading">
        User Panel
    </div>

    <!-- Sidebar Menu -->
    <nav class="flex-grow-1 overflow-y-auto">
        <ul class="list-group list-group-flush">
            {{-- Dashboard / Home --}}
            <li class="list-group-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <a href="{{ route('user.dashboard') }}" class="text-decoration-none">
                    <i class="fas fa-home me-2"></i> Home
                </a>
            </li>
            {{-- My Profile --}}
            <li class="list-group-item {{ request()->routeIs('user.profile.show') ? 'active' : '' }}">
                <a href="{{ route('user.profile.show') }}" class="text-decoration-none">
                    <i class="fas fa-user me-2"></i> My Profile
                </a>
            </li>
            {{-- My Orders --}}
            <li class="list-group-item list-group-item-action {{ request()->routeIs('user.orders.*') ? 'active' : '' }}">
                <a href="{{ route('user.orders.index') }}" class="text-decoration-none">
                    <i class="fas fa-receipt me-2"></i> My Orders
                </a>
            </li>
            {{-- Cart --}}
            <li class="list-group-item list-group-item-action {{ request()->routeIs('user.cart.index') || request()->routeIs('user.checkout.form') ? 'active' : '' }}">
                <a href="{{ route('user.cart.index') }}" class="text-decoration-none">
                    <i class="fas fa-shopping-cart me-2"></i> Cart
                </a>
            </li>

            {{-- Categories - NOW DYNAMICALLY GENERATED --}}
            @php
                // Fetch categories to display dynamically in sidebar
                // This is fine here, but for larger apps, consider a View Composer
                $categories = App\Models\Category::all();
            @endphp
            @foreach($categories as $category)
                <li class="list-group-item list-group-item-action {{ request()->routeIs('user.category.products') && request()->route('category') && request()->route('category')->slug == $category->slug ? 'active' : '' }}">
                    <a href="{{ route('user.category.products', $category->slug) }}" class="text-decoration-none">
                        <i class="fas fa-{{ strtolower($category->name) == 'tables' ? 'chair' : (strtolower($category->name) == 'wardrobe' ? 'tshirt' : (strtolower($category->name) == 'dining' ? 'utensils' : (strtolower($category->name) == 'sofa' ? 'couch' : (strtolower($category->name) == 'beds' ? 'bed' : 'cube')))) }} me-2"></i> {{ $category->name }}
                    </a>
                </li>
            @endforeach

            {{-- Logout Button is now here, as a list item, pushed to the bottom by mt-auto on its container --}}
            <li class="list-group-item mt-3 list-group-item-action {{ request()->routeIs('logout') ? 'active' : '' }}">
                <form method="POST" action="{{ route('logout') }}" class="d-block w-100">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none text-white p-0 d-block w-100 text-left">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>

<style>
    /* Specific styles for sidebar items to match screenshot and improve UX */
    #sidebar-wrapper .list-group-item {
        background-color: transparent; /* Ensure default is transparent */
        color: rgba(255, 255, 255, 0.8); /* White text for all links */
        border: none;
        padding: 10px 15px;
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease; /* Smooth transition */
        border-radius: 0; /* Remove rounding for full-width highlight */
        margin-bottom: 5px; /* Spacing between items */
    }
    #sidebar-wrapper .list-group-item a {
        color: inherit; /* Inherit color from parent li */
    }
    #sidebar-wrapper .list-group-item:hover,
    #sidebar-wrapper .list-group-item.active {
        background-color: #0d6efd; /* Blue background for active/hover */
        color: #ffffff; /* Ensure text remains white */
    }
    #sidebar-wrapper .list-group-item:hover a,
    #sidebar-wrapper .list-group-item.active a {
        color: #ffffff; /* Ensure link text remains white on hover/active */
    }
    #sidebar-wrapper .list-group-item i {
        margin-right: 10px; /* Icon spacing */
        width: 20px; /* Fixed width for icons */
        text-align: center;
    }

    /* Style for the logout button when moved inside the list */
    #sidebar-wrapper .list-group-item .btn-link {
        color: #ffffff !important; /* Explicitly set to white */
        text-align: left; /* Align text to the left */
        padding: 0; /* Remove default button padding */
    }
    /* The general .list-group-item.active rule will handle the active state background */
    /* Remove or comment out the following block as it's no longer needed:
    #sidebar-wrapper .list-group-item.text-danger.active {
        background-color: #dc3545 !important;
        box-shadow: inset 3px 0 0 #c82333;
    }
    #sidebar-wrapper .list-group-item.text-danger.active .btn-link {
        color: #ffffff !important;
    }
    */

    /* Override the default Bootstrap button focus/hover for cleaner look */
    .list-group-item-action:focus, .list-group-item-action:hover {
        background-color: #0d6efd;
    }
</style>