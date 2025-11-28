@extends('layouts.user') {{-- Ensure this extends layouts.user which does NOT have a top navbar --}}

@section('title', $product->name)

@section('content')
<div class="container-fluid py-3 ps-4 pb-4"> {{-- Consistent container padding --}}
    {{-- Product Name as the Main Page Title (Moved to top) --}}
    <h1 class="product-detail-page-title mb-3">{{ $product->name }}</h1>
    <hr class="mt-0 mb-4"> {{-- Horizontal rule for separation --}}

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-lg p-4 product-detail-card">
        <div class="row">
            <div class="col-md-7 d-flex flex-column align-items-center"> {{-- Increased column width for image --}}
                {{-- Main Product Image (Larger) --}}
                <div class="main-image-display-container mb-3 w-100">
                    @if ($product->images && count($product->images) > 0 && $product->images[0])
                        <img src="{{ asset($product->images[0]) }}" class="img-fluid rounded main-product-image" alt="{{ $product->name }}" id="mainProductImage">
                    @else
                        <img src="{{ asset('images/placeholder.png') }}" class="img-fluid rounded main-product-image" alt="No Image" id="mainProductImage">
                    @endif
                </div>

                {{-- Thumbnail Gallery (if multiple images exist) --}}
                @if ($product->images && count($product->images) > 1)
                    <div class="d-flex justify-content-center flex-wrap gap-2 thumbnail-gallery mt-3">
                        @foreach ($product->images as $index => $imagePath)
                            @if ($imagePath)
                                <img src="{{ asset($imagePath) }}" class="img-thumbnail thumbnail-image {{ $index === 0 ? 'active' : '' }}" alt="{{ $product->name }} thumbnail {{ $index + 1 }}" data-main-image="{{ asset($imagePath) }}">
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-md-5 d-flex flex-column justify-content-start"> {{-- Adjusted column width for details --}}
                <div>
                    <p class="fs-5 fw-bold text-dark mb-3">Price : Nu. {{ number_format($product->price, 0) }}</p> {{-- Standard text size and black color --}}
                    
                    <p class="h5 mt-4 text-dark mb-2">Description :</p>
                    @if($product->description)
                        <p class="text-secondary description-text d-inline-block ms-1"> {{-- d-inline-block for immediate word wrap --}}
                            {{ $product->description }}
                        </p>
                    @else
                        <p class="text-muted description-text d-inline-block ms-1">No detailed description available.</p>
                    @endif
                </div>

                {{-- Quantity Selector and Add to Cart Button (Simplified) --}}
                <form action="{{ route('user.cart.add') }}" method="POST" class="mt-4 pt-3 border-top">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="mb-3 d-flex align-items-center">
                        <label for="quantity" class="form-label me-3 h5 mb-0 text-dark">Quantity :</label>
                        <div class="input-group quantity-selector" style="width: 80px;"> {{-- Reduced width for input only --}}
                            <input type="number" name="quantity" id="quantity" class="form-control text-center form-control-sm" value="1" min="1" aria-label="Quantity">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styling for Product Detail Page */

    /* Product Name as Title */
    .product-detail-page-title {
        color: #343a40;
        font-size: 2.5rem; /* Larger font size */
        font-weight: 700;
        margin-left: 0; /* Align left */
        margin-bottom: 1rem;
    }

    .product-detail-card {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 2rem; /* Increased padding inside the card */
    }

    /* Main Image Display */
    .main-image-display-container {
        height: 450px; /* Fixed height for main image container */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa; /* Light background */
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eee;
    }
    .main-product-image {
        max-width: 100%;
        max-height: 100%; /* Ensure image fits container */
        width: auto;
        height: auto;
        object-fit: contain; /* Contain the image within the space */
        transition: transform 0.3s ease-in-out;
    }
    .main-product-image:hover {
        transform: scale(1.05); /* Slight zoom on hover */
    }

    /* Thumbnail Gallery */
    .thumbnail-gallery {
        margin-top: 1.5rem;
    }
    .thumbnail-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s, transform 0.2s;
        border-radius: 5px;
    }
    .thumbnail-image:hover, .thumbnail-image.active {
        border-color: #0d6efd; /* Highlight active/hovered thumbnail */
        transform: translateY(-3px);
    }

    /* Text Styling */
    .text-dark {
        color: #212529 !important; /* Force dark black for all text */
    }
    .text-secondary {
        color: #6c757d !important; /* Consistent grey for description text */
    }
    .fs-5 {
        font-size: 1.25rem !important; /* Keep price a bit larger */
    }
    .h5 {
        font-size: 1.25rem !important; /* Keep quantity label same size as price */
    }
    .description-text {
        white-space: pre-wrap; /* Preserves line breaks in description */
        margin-left: 0 !important; /* Ensure description starts right after label */
    }

    /* Quantity Selector Styling */
    .quantity-selector .form-control {
        border-color: #ced4da;
        color: #212529;
        text-align: center;
        font-size: 1rem;
        padding: 0.5rem 0.25rem; /* Adjusted padding */
        height: auto;
    }
    .quantity-selector .input-group-text { /* Hide + and - buttons */
        display: none;
    }

    /* Add to Cart Button */
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 5px;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Thumbnail image switching logic
        const mainProductImage = document.getElementById('mainProductImage');
        document.querySelectorAll('.thumbnail-image').forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                mainProductImage.src = this.dataset.mainImage;
                document.querySelectorAll('.thumbnail-image').forEach(img => img.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Quantity selector logic (Simplified for input-only)
        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.addEventListener('change', function() {
                let currentValue = parseInt(this.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    this.value = 1; // Ensure minimum is 1
                }
            });
            // Ensure initial value is at least 1
            if (parseInt(quantityInput.value) < 1) {
                quantityInput.value = 1;
            }
        }
    });
</script>
@endpush