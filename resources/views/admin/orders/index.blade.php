@extends('layouts.admin') {{-- Assuming your admin layout file is layouts/admin.blade.php --}}

@section('title', 'Manage Orders')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-dark">Manage Customer Orders</h1>

    @if(session('success'))
        <div class="alert alert-success mb-4 shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            @if ($orders->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    No orders have been placed yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ordered On</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? $order->customer_name }}</td> {{-- Use user's name or custom customer name --}}
                                    <td>{{ $order->customer_phone }}</td>
                                    <td>Nu. {{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{
                                            $order->status == 'pending' ? 'bg-warning text-dark' :
                                            ($order->status == 'processing' ? 'bg-info' :
                                            ($order->status == 'dispatched' ? 'bg-primary' :
                                            ($order->status == 'delivered' ? 'bg-success' : 'bg-secondary')))
                                        }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white me-2">View</a>
                                        {{-- Update Status button/form will go here in Part 3 --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection