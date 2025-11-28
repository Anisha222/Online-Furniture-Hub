@extends('layouts.user')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    {{-- Changed 'display-5' to 'fs-3' for a smaller, more balanced title size --}}
    <h1 class="mb-5 text-center text-dark fw-bold fs-3">Proceed to Checkout</h1>

    @if ($errors->any())
        <div class="alert alert-danger mb-4 shadow-sm" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white py-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold">Delivery Information</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.checkout.place_order') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control form-control-lg rounded-2" id="full_name" name="full_name" value="{{ old('full_name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control form-control-lg rounded-2" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone ?? '') }}" placeholder="e.g., 975XXXXXXXX" required>
                        </div>
                        <div class="mb-4">
                            <label for="shipping_address" class="form-label fw-semibold">Shipping Address</label>
                            <textarea class="form-control rounded-2" id="shipping_address" name="shipping_address" rows="4" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success fw-bold w-100 py-2.5 rounded-2">place order (pay on whatsapp)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-light py-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold text-dark">Order Summary</h4>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush mb-4 border-bottom pb-3">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-0">
                                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                <span class="fw-semibold">Nu. {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fs-5 fw-bold text-dark">Total</span>
                        <span class="fs-5 fw-bold text-success">Nu. {{ number_format($totalAmount, 2) }}</span>
                    </div>
                    <p class="text-muted text-center mt-3 small">
                        Payment Method: <span class="fw-semibold text-dark">Pay on WhatsApp</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection