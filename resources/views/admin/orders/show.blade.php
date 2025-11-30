@extends('layouts.admin')

@section('title', 'Order Details - #' . $order->id)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- Filled the empty H1 tag for better structure --}}
        <h1 class="fw-bold text-dark mb-0"></h1>
        {{-- BACK BUTTON COLOR CHANGED TO BLUE (btn-primary) --}}
        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Back</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4 shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4 shadow-sm" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mb-4 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-primary text-white py-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold">Customer Information</h5>
                </div>
                <div class="card-body p-4">
                    <p class="mb-1"><strong>Customer Name:</strong> {{ $order->user->name ?? $order->customer_name }}</p>
                    <p class="mb-1"><strong>Customer Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                    <p class="mb-1"><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    <p class="mb-0"><strong>Ordered On:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light py-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold text-dark">Order Items</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Product Not Found' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Nu. {{ number_format($item->price, 2) }}</td>
                                        <td>Nu. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">Total Amount:</td>
                                    <td>Nu. {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-success text-white py-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold">Order Status</h5>
                </div>
                <div class="card-body p-4">
                    <p class="mb-2"><strong>Current Status:</strong>
                        <span class="badge {{
                            $order->status == 'pending' ? 'bg-warning text-dark' :
                            ($order->status == 'seen' ? 'bg-info' :
                            ($order->status == 'dispatched' ? 'bg-primary' :
                            ($order->status == 'delivered' ? 'bg-success' :
                            ($order->status == 'cancelled' ? 'bg-danger' : 'bg-secondary'))))
                        }} fs-6">{{ ucfirst($order->status) }}</span>
                    </p>
                    <p class="mb-4"><strong>Payment Method:</strong> {{ $order->payment_method }}</p>

                    <h6 class="fw-bold text-dark mb-3">Update Order Status</h6>
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH') {{-- Corrected from PUT to PATCH --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Select New Status</label>
                            <select class="form-select" id="status" name="status" required>
                                {{-- Ensure these values match your validation rules in AdminOrderController --}}
                                <!-- <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option> -->
                                <option value="Seen" {{ $order->status == 'Seen' ? 'selected' : '' }}>Seen</option>
                                <!-- <option value="Confirmed" {{ $order->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option> -->
                                <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection