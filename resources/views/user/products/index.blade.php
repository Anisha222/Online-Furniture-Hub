<!-- resources/views/user/products/index.blade.php -->
@extends('layouts.user')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Furniture Shopping</h1>
            
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <a href="{{ route('user.products.category', $category->name) }}" class="btn btn-primary">View {{ $category->name }}s</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection