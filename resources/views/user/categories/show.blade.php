@extends('layouts.user') {{-- CRITICAL: Ensure this extends layouts.user which does NOT have a top navbar --}}

@section('title', $category->name . ' Products')

@section('content')
<div class="container-fluid py-3 ps-4 pb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="category-main-title mb-0">{{ $category->name }}</h1>
    </div>
    <hr class="mt-0 mb-4">

    @if ($products->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            No products found in the '{{ $category->name }}' category.
            <p class="mt-2">Please check back later.</p>
        </div>
    @else
        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 product-card shadow-sm">
                        {{-- Link the entire card content (image, name, price) to the product detail page --}}
                        <a href="{{ route('user.products.show', $product->id) }}" class="text-decoration-none text-dark d-flex flex-column h-100">
                            {{-- Product Image - Enforced Square Shape --}}
                            <div class="product-card-image-container">
                                @if (!empty($product->images) && count($product->images) > 0 && $product->images[0])
                                    <img src="{{ asset($product->images[0]) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('images/placeholder.png') }}" class="card-img-top product-image" alt="No Image">
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column text-center bg-light">
                                <h5 class="card-title text-dark fw-bold mb-1">{{ $product->name }}</h5> {{-- Changed to text-dark --}}
                                <p class="card-text text-dark fs-5 fw-bold mt-auto mb-2">Nu. {{ number_format($product->price, 0) }}</p> {{-- Changed to text-dark --}}
                            </div>
                        </a>
                        {{-- Add to Cart button (separate from the product link) --}}
                        {{-- This section has been commented out to remove the "Add to Cart" button from category listings --}}
                        {{--
                        <div class="card-footer bg-transparent border-top-0 pt-2 pb-2 text-center">
                            <form action="{{ route('user.cart.add') }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Add to Cart</button>
                            </form>
                        </div>
                        --}}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Custom CSS for Category Product Display Page */

    /* Category Title Styling - "Tables" title */
    .category-main-title {
        color: #343a40;
        font-size: 2.2rem;
        font-weight: 700;
        margin-left: 0;
    }

    /* Product Card Styling (consistent with dashboard) */
    .product-card {
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        background-color: #ffffff;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* Enforce Square Image Container */
    .product-card-image-container {
        width: 100%;
        padding-bottom: 100%; /* Creates a square aspect ratio (1:1) */
        position: relative;
        overflow: hidden;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Product Image Styling */
    .product-image {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Crops the image to fill the square */
        top: 0;
        left: 0;
    }

    /* Card Body Adjustments */
    .product-card .card-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-card .card-title {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .product-card .btn-primary {
        margin-top: 10px;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    /* REMOVED SPECIFIC COLOR STYLES AS text-dark IS USED IN HTML */
    /* .text-primary { color: #0d6efd !important; } */
    /* .text-success { color: #198754 !important; } */

    /* Overall page background for main content area */
    body {
        background-color: #f8f9fa;
    }
</style>
@endpush