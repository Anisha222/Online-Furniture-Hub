@extends('layouts.app') {{-- Ensure 'layouts.app' exists and is correctly configured --}}

@section('title', 'My Orders')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* Light background for consistency, similar to shopping cart */
        font-family: Arial, sans-serif;
    }

    .order-container {
        display: flex;
        flex-direction: column;
        align-items: center; /* This centers the cards themselves horizontally within the container */
        padding: 20px 0;
        width: 100%; /* Ensure container uses available width */
        max-width: 700px; /* Max width for the entire order list block */
        /* MODIFIED: Removed margin: 0 auto; so it aligns left */
        /* margin: 0 auto; */
    }

    .order-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        padding: 15px 20px;
        margin: 10px 0;
        width: 90%; /* Take 90% of the parent's width (which is the order-container) */
        max-width: 650px; /* Increased max width for individual order cards */
        box-sizing: border-box; /* Include padding and border in the element's total width and height */
    }

    .order-header {
        font-weight: bold;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .order-header span {
        display: inline-block;
        min-width: 80px;
    }

    .order-item {
        font-size: 15px;
        margin-bottom: 3px;
    }

    .order-total {
        font-weight: bold;
        font-size: 16px;
        margin-top: 10px;
    }

    .order-status {
        margin-top: 8px;
        font-weight: bold;
    }

    .status-pending { /* Added for clarity based on your controller */
        color: grey;
    }

    .status-seen {
        color: red;
    }

    .status-dispatched {
        color: orange;
    }

    .status-delivered { /* Added for clarity */
        color: green;
    }

    .view-details-link {
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .view-details-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }
</style>

<div class="flex min-h-screen">
    <!-- Include Sidebar Partial -->
    @include('user.partials.sidebar') {{-- Ensure 'user.partials.sidebar' exists --}}

    <!-- Main Content -->
    {{-- This div controls the overall alignment of its children --}}
    <div class="flex-1 ml-64 p-6 flex flex-col"> {{-- Removed 'items-center' to allow left alignment --}}
        {{-- H1 will naturally align left due to its parent not centering --}}
        <h1 class="text-2xl font-bold mb-6 text-left">My Orders</h1>

        {{-- This container will now align left and still center cards internally --}}
        <div class="order-container">
            @if($orders->isEmpty())
                <p>You haven't placed any orders yet. <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Start shopping!</a></p>
            @else
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <span>Order ID:</span> {{ $order->id }} <br>
                            <span>Date:</span> {{ $order->created_at->format('M d, Y') }}
                        </div>

                        {{-- Display up to 2 items directly in the card, then summarize if more --}}
                        @php $itemCount = 0; @endphp
                        @foreach($order->orderItems as $item)
                            @if($itemCount < 2) {{-- Show first two items --}}
                                <div class="order-item">
                                    {{ $item->product_name }} x {{ $item->quantity }} <br>
                                    Nu. {{ number_format($item->price, 2) }} each
                                </div>
                                @php $itemCount++; @endphp
                            @endif
                        @endforeach

                        @if($order->orderItems->count() > 2)
                            <div class="order-item text-sm text-gray-600">
                                ... and {{ $order->orderItems->count() - 2 }} more items
                            </div>
                        @endif

                        <div class="order-total">
                            Total : Nu. {{ number_format($order->total_amount, 2) }}
                        </div>
                        <div class="order-status">
                            Status :
                            <span class="
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
                        <div class="mt-4 text-right">
                             <a href="{{ route('user.orders.show', $order->id) }}" class="view-details-link">View Details</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection