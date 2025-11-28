@extends('layouts.app')

@section('content')
    <div class="px-6 py-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Your Shopping Cart</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">

            @if ($cartItems->isEmpty())
                <div class="text-center py-10">
                    <h4 class="text-lg font-semibold mb-4 text-gray-700">No Items in Cart</h4>
                    <a href="{{ route('user.dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-300">Continue Shopping</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold text-gray-600">Product</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-600">Price</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-600">Quantity</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-600">Subtotal</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($cartItems as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-16 h-16 flex-shrink-0 border rounded-md overflow-hidden bg-gray-100">
                                                {{-- START OF ROBUST IMAGE DISPLAY LOGIC --}}
                                                @php
                                                    $finalImageUrl = null;
                                                    $imageDbPath = $item->product->first_image_path ?? null;

                                                    if ($imageDbPath) {
                                                        $processedPath = null;
                                                        
                                                        // Attempt to decode as JSON
                                                        $decodedPaths = json_decode($imageDbPath, true);

                                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedPaths) && count($decodedPaths) > 0) {
                                                            // It was a valid JSON array, take the first element
                                                            $processedPath = $decodedPaths[0];
                                                        } else {
                                                            // Not valid JSON or empty array, treat it as a plain string path
                                                            $processedPath = $imageDbPath;
                                                        }

                                                        if ($processedPath) {
                                                            // Clean up the path:
                                                            // 1. Convert backslashes to forward slashes (common on Windows paths in DB)
                                                            $processedPath = str_replace('\\', '/', $processedPath);
                                                            // 2. Remove any explicit '/storage/' or 'storage/' prefix to avoid duplication
                                                            $processedPath = ltrim($processedPath, '/storage/');
                                                            $processedPath = ltrim($processedPath, 'storage/');

                                                            // 3. Ensure filename has underscores if spaces/encoded spaces were used (robustness)
                                                            $processedPath = str_replace(' ', '_', $processedPath);
                                                            $processedPath = str_replace('%20', '_', $processedPath);

                                                            // 4. Correct file extension if truncated (e.g., '.jp' -> '.jpeg')
                                                            // Check for common truncations and fix
                                                            if (substr($processedPath, -3) === '.jp') {
                                                                $processedPath .= 'eg'; // Assumes .jpeg
                                                            } elseif (substr($processedPath, -4) === '.jpe') {
                                                                $processedPath .= 'g'; // Assumes .jpeg
                                                            } elseif (substr($processedPath, -3) === '.jg') {
                                                                $processedPath = substr($processedPath, 0, -1) . 'pg'; // Fix .jg to .jpg
                                                            }
                                                            // Add more checks for other extensions if needed (e.g., .png, .gif)

                                                            // Construct the final URL
                                                            $finalImageUrl = asset('storage/' . $processedPath);
                                                        }
                                                    }
                                                @endphp

                                                @if ($finalImageUrl)
                                                    <img src="{{ $finalImageUrl }}" alt="{{ $item->product->name ?? 'Product Image' }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs text-center">Image Not Found</div>
                                                @endif
                                                {{-- END OF ROBUST IMAGE DISPLAY LOGIC --}}
                                            </div>
                                            <a href="{{ route('user.products.show', $item->product->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                {{ $item->product->name ?? 'N/A' }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">Nu. {{ number_format($item->product->price ?? 0, 2) }}</td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('user.cart.update', $item) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                   class="w-16 text-center border rounded"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">Nu. {{ number_format($item->quantity * ($item->product->price ?? 0), 2) }}</td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('user.cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                                Remove
                                            </button>
                                            </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        {{-- Total Row --}}
                        <tfoot class="bg-white border-t border-gray-200">
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-right font-semibold text-gray-700">Total:</td>
                                <td colspan="2" class="py-4 px-4 font-bold text-gray-900">Nu. {{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Buttons below table --}}
                <div class="flex justify-end items-center mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('user.dashboard') }}"
                       class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition duration-300 mr-3">
                       Continue Shopping
                    </a>

                    <a href="{{ route('user.checkout.form') }}"
                       class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-300">
                       Proceed to Checkout
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection