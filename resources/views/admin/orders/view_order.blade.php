@extends('layouts.admin') {{-- Extends the admin specific layout --}}

@section('title', 'View Orders') {{-- Sets the title for the header --}}

@section('content')
    <div class="px-6 py-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">View Orders</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            {{-- Check if there are any orders, considering that some might be filtered out --}}
            @php
                $displayableOrders = $orders->filter(function ($order) {
                    return ($order->user->name ?? 'Guest User') !== 'admin';
                });
            @endphp

            @if ($displayableOrders->isEmpty())
                <div class="text-center py-10">
                    <h4 class="text-lg font-semibold mb-4 text-gray-700">No User Orders Found</h4>
                    <p class="text-gray-600">Customers haven't placed any orders yet, or only admin orders exist.</p>
                </div>
            @else
                {{-- The main div provides the rounded corners and shadow, overflow-hidden ensures child borders are clipped --}}
                <div class="overflow-x-auto overflow-hidden">
                    <table class="table table-bordered table-striped"> {{-- border-collapse is essential for clean grid lines --}}
                        <thead class="bg-gray-50"> {{-- Header background --}}
                            <tr>
                                {{-- Apply borders to each header cell --}}
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Order ID</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Customer</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Amount</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Status</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Payment</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Date</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($orders as $order)
                                {{-- Only display if the customer's name is not 'admin' --}}
                                @if (($order->user->name ?? 'Guest User') !== 'admin')
                                    <tr>
                                        {{-- Apply borders to each data cell --}}
                                        <td class="py-3 px-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-200">#{{ $order->id }}</td>
                                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700 border border-gray-200">
                                            {{ $order->user->name ?? 'Guest User' }}
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700 border border-gray-200">Nu. {{ number_format($order->total_amount, 2) }}</td>
                                        <td class="py-3 px-4 whitespace-nowrap border border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($order->status == 'Pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status == 'Confirmed') bg-blue-100 text-blue-800
                                                @elseif($order->status == 'Shipped') bg-purple-100 text-purple-800
                                                @elseif($order->status == 'Delivered') bg-green-100 text-green-800
                                                @elseif($order->status == 'Seen') bg-gray-200 text-gray-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700 border border-gray-200">{{ $order->payment_method }}</td>
                                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700 border border-gray-200">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-4 whitespace-nowrap text-sm font-medium border border-gray-200">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View Details</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination links will still be based on the original collection, but only filtered rows are shown --}}
                <div class="mt-4">
                    {{ $orders->links() }} {{-- Pagination links --}}
                </div>
            @endif
        </div>
    </div>
@endsection