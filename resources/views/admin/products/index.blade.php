@extends('layouts.admin') {{-- Assuming you have an admin layout --}}

@section('title', 'Product List')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Products</h4>
        {{-- Link to the create product form --}}
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary float-end">Add Product</a>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Images</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td> {{-- Accessing category name via relationship --}}
                    <td>Nu. {{ number_format($product->price, 2) }}</td>
                    <td>
                        @if ($product->images)
                            @foreach($product->images as $imagePath)
                                <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 5px;">
                            @endforeach
                        @else
                            No Images
                        @endif
                    </td>
                    <td>{{ Str::limit($product->description, 50) }}</td> {{-- Using Str::limit to shorten description --}}
                    {{-- MODIFIED SECTION START --}}
                    <td>
                        {{-- Use d-flex and gap-2 to place buttons side-by-side with a gap --}}
                        <div class="d-flex gap-2"> 
                            {{-- EDIT BUTTON: Use w-50 or flex-fill to ensure equal size within the container --}}
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-info flex-fill">Edit</a>
                            
                            {{-- DELETE FORM: Wrap the button in a form, make the form d-inline and use flex-fill on the button --}}
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </div>
                    </td>
                    {{-- MODIFIED SECTION END --}}
                </tr>
                @empty
                <tr>
                    <td colspan="8">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection