@extends('layouts.app') {{-- Adjust this to your actual user layout file path --}}

@section('title', 'Sofa')

@section('content')
<div class="container-fluid">
    <h2 class="my-4">Sofa</h2>

    @if ($products->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            No sofa products found at the moment.
            <p class="mt-2">Please check back later or browse other categories.</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if ($product->images && count($product->images) > 0)
                            <img src="{{ asset($product->images[0]) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/placeholder.png') }}" class="card-img-top" alt="No Image" style="height: 250px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary">{{ $product->name }}</h5>
                            <p class="card-text text-muted">Category: {{ $product->category->name }}</p>
                            <p class="card-text fs-5 fw-bold text-success">Nu. {{ number_format($product->price, 2) }}</p>
                            <p class="card-text flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                            <div class="mt-auto">
                                <button class="btn btn-dark add-to-cart-btn w-100" data-product-id="{{ $product->id }}">
                                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
{{-- Example JavaScript for add to cart --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                alert('Product ' + productId + ' added to cart! (Placeholder action)');
            });
        });
    });
</script>
@endpush