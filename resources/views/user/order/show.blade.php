@extends('layouts.app') {{-- Assuming you have a main layout file --}}

@section('title', 'Order Details - #' . $order->id)

@section('content')
<style>
    body {
        background-color: #d6f5d6; /* light green background */
        font-family: Arial, sans-serif;
    }

    .order-detail-container {
        display: flex;
        flex-direction: column;
        padding: 20px 0;
        width: 100%;
    }

    .order-detail-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        padding: 20px 30px;
        margin: 10px 0;
        width: 90%;
        max-width: 600px;
        margin-left: 0; /* Ensures the card starts at the left of its container */
    }

    .detail-header {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .detail-section {
        margin-bottom: 15px;
    }

    .detail-label {
        font-weight: bold;
        color: #555;
        display: inline-block;
        width: 150px; /* Adjust as needed */
    }

    .detail-value {
        color: #333;
    }

    .items-list {
        list-style-type: none;
        padding-left: 0;
        margin-top: 10px;
    }

    .items-list li {
        margin-bottom: 5px;
        font-size: 16px;
        color: #333;
    }

    .status-pending {
        color: grey;
    }

    .status-seen {
        color: red;
    }

    .status-dispatched {
        color: orange;
    }

    .status-delivered {
        color: green;
    }

    .back-button-container {
        margin-bottom: 20px;
        text-align: right;
    }

    .back-button {
        background-color: #007bff;
        color: white;
        /* MODIFIED: Increased padding for a nicer size */
        padding: 12px 20px; /* Slightly more vertical and horizontal padding */
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        display: inline-block;
        /* NEW: Increased font size for better visibility */
        font-size: 16px;
        font-weight: bold; /* Make the text a bit bolder */
    }

    .back-button:hover {
        background-color: #0056b3;
    }
</style>

<div class="flex min-h-screen">
    <!-- Include Sidebar Partial -->
    @include('user.partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 ml-64 p-6 flex flex-col">
        <div class="back-button-container">
            {{-- MODIFIED: Changed text to 'Back' only --}}
            <a href="{{ route('user.orders.index') }}" class="back-button">Back</a>
        </div>

        <h1 class="text-2xl font-bold mb-6">Order Details</h1>

        <div class="order-detail-container">
            <div class="order-detail-card">
                <div class="detail-header">Order #{{ $order->id }}</div>

                <div class="detail-section">
                    <span class="detail-label">Order Date:</span>
                    <span class="detail-value">{{ $order->created_at->format('M d, Y H:i A') }}</span>
                </div>

                <div class="detail-section">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value
                        @if($order->status === 'pending') status-pending
                        @elseif($order->status === 'seen') status-seen
                        @elseif($order->status === 'dispatched') status-dispatched
                        @elseif($order->status === 'delivered') status-delivered
                        @else status-pending
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="detail-section">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value">Nu. {{ number_format($order->total_amount, 2) }}</span>
                </div>

                <div class="detail-section">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value">{{ $order->payment_method }}</span>
                </div>

                <div class="detail-section">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value">{{ $order->customer_name }}</span>
                </div>

                <div class="detail-section">
                    <span class="detail-label">Contact Number:</span>
                    <span class="detail-value">{{ $order->customer_phone }}</span>
                </div>

                <div class="detail-section">
                    <span class="detail-label">Shipping Address:</span>
                    <span class="detail-value">{{ $order->shipping_address }}</span>
                </div>

                <h3 class="font-bold text-lg mt-6 mb-3 border-b pb-2">Items Ordered:</h3>
                <ul class="items-list">
                    @foreach($order->orderItems as $item)
                        <li>
                            {{ $item->product_name }} (Nu. {{ number_format($item->price, 2) }}) x {{ $item->quantity }}
                            = Nu. {{ number_format($item->price * $item->quantity, 2) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection