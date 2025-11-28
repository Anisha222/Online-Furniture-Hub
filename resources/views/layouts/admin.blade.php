<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Online Furniture System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        main {
            padding-top: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <h4 class="text-white text-center mb-4">
                        <i class="fas fa-couch me-2"></i>Admin Panel
                    </h4>
                    <ul class="nav flex-column">
                        {{-- Admin Dashboard Link --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->is('admin/products/create') ? 'active' : '' }}" href="{{ route('admin.products.create') }}">
                                <i class="fas fa-plus-circle"></i> Add Product
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            {{-- Changed to link to orders index, as "Update Order" alone needs a specific order ID --}}
                            <a class="nav-link text-white {{ request()->is('admin/orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-edit"></i> Update Order
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->is('admin/orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-cart"></i> View Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->is('admin/products') || request()->is('admin/products/*') && !request()->is('admin/products/create') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                <i class="fas fa-box"></i> View Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i> View Users
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="nav-link text-white" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>