{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin') {{-- Extend the main admin layout --}}

@section('title', 'Dashboard') {{-- Set the title for this specific page --}}

@section('content')
    <!-- Your main content for the admin dashboard goes here -->
    <h1 class="h2 mb-4">Hello Admin</h1>
    <!-- <p>Welcome, {{ Auth::user()->name ?? 'Admin' }}! This is your main administrative control panel.</p> -->

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">Manage all products.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-info">View Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text">Review and update customer orders.</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-info">View Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Manage user accounts.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-info">View Users</a>
                </div>
            </div>
        </div>
    </div>
    {{-- You can add more dashboard widgets/info here --}}
@endsection