@extends('layouts.app') {{-- Ensure this extends your correct user layout --}}

@section('title', 'Wardrobe') {{-- Set the title for this specific page --}}

@section('content')
<div class="container py-4">
    <h2 class="my-4 text-center text-dark fw-bold">Wardrobe</h2> {{-- Changed heading to Wardrobe --}}

    @if ($products->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            No wardrobe products found at the moment.
            <p class="mt-2">Please check back later or browse other categories.</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($products as $product)
                <div class="col d-flex">
                    <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden product-card">
                        {{-- Link the entire card content to the product detail page --}}
                        <a href="{{ route('user.products.show', $product->id) }}" class="text-decoration-none text-dark d-flex flex-column h-100">
                            {{-- Image Display Logic --}}
                            @if ($product->images && count($product->images) > 0 && $product->images[0])
                                <img src="{{ asset($product->images[0]) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: contain; padding: 10px; background-color: white;">
                            @else
                                {{-- Placeholder image if no image is available --}}
                                <img src="{{ asset('images/placeholder.png') }}" class="card-img-top" alt="No Image Available" style="height: 180px; object-fit: contain; padding: 10px; background-color: white;">
                            @endif

                            <div class="card-body d-flex flex-column text-center bg-light-green">
                                <h5 class="card-title text-primary fw-normal mb-1">{{ $product->name }}</h5>
                                <p class="card-text fs-5 fw-bold text-primary mb-3">Nu. {{ number_format($product->price, 0) }}</p>
                                @if($product->description && Str::length($product->description) > 0)
                                    <p class="card-text text-secondary flex-grow-1 small mt-auto">{{ Str::limit($product->description, 50) }}</p>
                                @endif
                            </div>
                        </a>
                        {{-- Add to Cart button on the listing page (outside the link to PDP) --}}
                        <div class="card-footer bg-transparent border-top-0 pt-2 pb-2 text-center">
                            <button class="btn btn-primary add-to-cart-btn w-100" data-product-id="{{ $product->id }}">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Custom styling for product cards, consistent with tables.blade.php */
    .product-card {
        background-color: #f7fcf8; /* A very light green, matching the image background */
        border: 1px solid #e0ffe0; /* Light green border */
        cursor: pointer; /* Indicate clickable cards */
    }
    .product-card:hover {
        transform: translateY(-3px); /* Subtle hover effect */
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .product-card .card-img-top {
        border-bottom: 1px solid #e0ffe0; /* Separator for image */
    }
    .product-card .card-body {
        padding: 10px;
    }
    .product-card .card-title {
        font-size: 1.1rem;
        color: #00008b !important; /* Darker blue for titles */
    }
    .card-text.text-primary {
        font-size: 1.2rem;
        color: #00008b !important; /* Darker blue for prices */
    }
    .btn-primary {
        background-color: #0d6efd; /* Standard blue button */
        border-color: #0d6efd;
    }
    /* Styles for the link wrapping the card content */
    .product-card > a {
        display: flex;
        flex-direction: column;
        height: 100%; /* Make the link cover the whole card content area */
        justify-content: space-between;
    }
    .product-card .card-body {
        flex-grow: 1; /* Allow body to grow and push footer down */
    }
    /* Overall page background if not already set in layouts.app */
    body {
        background-color: #f0fff0; /* A very light green for the whole page */
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add to Cart on listing page
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent card click event from firing when button is clicked
            const productId = this.dataset.productId;
            alert('Product ' + productId + ' added to cart! (Wardrobe page action)');
            // Implement actual AJAX add to cart logic here
            });
        });
    });
</script>
@endpush