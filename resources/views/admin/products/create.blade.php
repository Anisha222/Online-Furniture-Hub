@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- CHANGE THIS LINE FROM @method('PUT') TO @method('PATCH') --}}
            @if(isset($product))
                @method('PATCH') {{-- Corrected: Use PATCH as defined in your routes/web.php --}}
            @endif

            {{-- The rest of your form code remains the same --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="product_id" class="form-label fw-bold">Product ID:</label>
                        <input type="text" id="product_id" name="product_id" class="form-control" placeholder="Enter product ID" value="{{ old('product_id', $product->product_id ?? '') }}">
                        @error('product_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label fw-bold">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter product name" value="{{ old('name', $product->name ?? '') }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="price" class="form-label fw-bold">Price:</label>
                        <div class="input-group">
                            <span class="input-group-text">Nu</span>
                            <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ old('price', $product->price ?? '0.00') }}" required>
                        </div>
                        @error('price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="category" class="form-label fw-bold">Category:</label>
                        <select id="category" name="category_id" class="form-select" required>
                            <option value="">--Select Category--</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-bold">Product Images:</label>
                <div class="row">
                    @php
                        $existingImages = isset($product) ? ($product->images ?? []) : [];
                    @endphp

                    @for ($i = 0; $i < 4; $i++)
                        <div class="col-md-6 mb-3">
                            <div class="image-upload-container border p-2 rounded">
                                <label for="image{{ $i + 1 }}" class="form-label">Image {{ $i + 1 }} 
                                    @if ($i == 0 && !isset($product)) 
                                        <span class="text-danger">*</span>
                                    @else
                                        (Optional)
                                    @endif
                                </label>
                                <input type="file" name="images[{{ $i }}]" id="image{{ $i + 1 }}" class="form-control" accept="image/*" 
                                    @if ($i == 0 && !isset($product) && !isset($existingImages[$i])) 
                                        required
                                    @endif
                                >
                                <div class="image-preview mt-2" id="preview{{ $i + 1 }}">
                                    @if(isset($existingImages[$i]) && $existingImages[$i])
                                        <img src="{{ asset($existingImages[$i]) }}" class="img-thumbnail" style="max-height: 150px; display: block; margin-top: 10px;">
                                    @endif
                                </div>
                                
                                @if(isset($existingImages[$i]) && $existingImages[$i])
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="clear_images[{{ $i }}]" value="1" id="clear_image{{ $i + 1 }}">
                                        <label class="form-check-label" for="clear_image{{ $i + 1 }}">
                                            Remove current image
                                        </label>
                                    </div>
                                @endif
                            </div>
                            @error('images.' . $i)
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endfor
                </div>
                @error('images')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label fw-bold">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Enter product description">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.products.index') }}" class="btn btn-danger me-2">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas {{ isset($product) ? 'fa-save' : 'fa-plus' }} me-2"></i>{{ isset($product) ? 'Update Product' : 'Add Product' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        for (let i = 1; i <= 4; i++) {
            const imageInput = document.getElementById(`image${i}`);
            const previewContainer = document.getElementById(`preview${i}`);

            imageInput.addEventListener('change', function() {
                previewContainer.innerHTML = '';

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewContainer.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px; display: block; margin-top: 10px;">`;
                    };

                    reader.readAsDataURL(this.files[0]);
                }
            });

            const clearCheckbox = document.getElementById(`clear_image${i}`);
            if (clearCheckbox) {
                clearCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        imageInput.value = '';
                        previewContainer.innerHTML = '';
                    }
                });
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files.length > 0 && clearCheckbox.checked) {
                        clearCheckbox.checked = false;
                    }
                });
            }
        }
    });
</script>
@endsection