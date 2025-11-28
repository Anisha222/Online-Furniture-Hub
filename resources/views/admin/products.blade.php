@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h2 class="text-2xl font-semibold mb-6 text-center">Add Product</h2>

    @php
        // Ensure $categories is defined to avoid errors
        $categories = $categories ?? collect();
    @endphp

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product ID -->
        <div class="mb-4">
            <label for="product_id" class="block font-medium text-gray-700">Product ID:</label>
            <input type="text" id="product_id" name="product_id" 
                   value="{{ old('product_id') }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" readonly>
        </div>

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700">Name:</label>
            <input type="text" id="name" name="name" 
                   value="{{ old('name') }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label for="price" class="block font-medium text-gray-700">Price:</label>
            <input type="number" id="price" name="price" 
                   value="{{ old('price') }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label for="category" class="block font-medium text-gray-700">Category:</label>
            <select id="category" name="category" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                <option value="">--Select--</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @if($categories->isEmpty())
                <p class="text-sm text-gray-500 mt-1">No categories available yet.</p>
            @endif
        </div>

        <!-- Images -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Images:</label>
            @for ($i = 0; $i < 4; $i++)
                <input type="file" name="images[]" class="mb-2">
            @endfor
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block font-medium text-gray-700">Description:</label>
            <textarea id="description" name="description" rows="5" 
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('description') }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Upload
            </button>
        </div>
    </form>
</div>
@endsection
