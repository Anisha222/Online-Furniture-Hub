<div class="sidebar-heading">Admin Panel</div>
<div class="list-group list-group-flush flex-grow-1">

    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <p class="text-muted small fw-bold mt-3 mb-1">Product Management</p>
    <a href="{{ route('admin.products.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Add Product
    </a>
    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.edit') ? 'active' : '' }}">
        <i class="fas fa-box-open"></i> View Products
    </a>
    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="fas fa-tags"></i> Manage Categories
    </a>

    <p class="text-muted small fw-bold mt-3 mb-1">Order Management</p>
    {{-- The "Update Order" link has been completely removed --}}
    <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') || request()->routeIs('admin.orders.update_status') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> View Orders
    </a>

    <p class="text-muted small fw-bold mt-3 mb-1">User Management</p>
    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
        <i class="fas fa-users"></i> View Users
    </a>

</div>

<div class="logout-btn-container mt-auto">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none text-danger p-0 d-block w-100 text-left">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>