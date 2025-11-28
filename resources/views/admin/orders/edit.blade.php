@extends('layouts.admin')

@section('title', 'Order Details - #' . $order->id)

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Order Details - #{{ $order->id }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4>Customer & Shipping Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Customer Phone:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Ordered by User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4>Update Order Status</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label">Order Status:</label>
                            <select class="form-select" id="status" name="status">
                                @foreach ($statuses as $statusOption)
                                    <option value="{{ $statusOption }}" {{ $order->status == $statusOption ? 'selected' : '' }}>
                                        {{ ucfirst($statusOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4>Order Items</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h5>{{ $item->product_name }}</h5>
                                    <small class="text-muted">Price: Nu. {{ number_format($item->product_price, 2) }}</small>
                                </div>
                                <span class="badge bg-secondary rounded-pill">Qty: {{ $item->quantity }}</span>
                                <span>Total: Nu. {{ number_format($item->product_price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center fw-bold fs-5">
                        <span>Grand Total:</span>
                        <span>Nu. {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Order List</a>
    </div>
</div>
@endsection