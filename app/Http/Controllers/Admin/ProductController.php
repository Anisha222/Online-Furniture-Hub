<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // Import the Product model
use App\Models\Category; // Import the Category model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // For file uploads
use Illuminate\Validation\ValidationException; // To catch validation specific exceptions

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        // Eager load the category relationship to avoid N+1 query problem
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories for the dropdown
        // When creating, we don't pass a 'product' object, so the view knows it's a creation form.
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|string|unique:products,product_id|max:255',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                // First image is required, others are optional
                'images.0' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images.1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images.2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images.3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            throw $e;
        }

        $uploadedImagePaths = [];
        
        // Loop through all potential image inputs (0 to 3)
        // Ensure that even if fewer than 4 images are uploaded, their original indexes are considered
        for ($i = 0; $i < 4; $i++) {
            $imageFile = $request->file('images.' . $i);

            if ($imageFile && $imageFile->isValid()) {
                // Generate a unique filename
                $fileName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                // Store in 'public/products' directory
                $path = $imageFile->storeAs('products', $fileName, 'public'); // Store to public disk
                $uploadedImagePaths[$i] = Storage::url($path); // Get the public URL
            } else {
                $uploadedImagePaths[$i] = null; // Mark as null if no image for this slot
            }
        }
        
        // Filter out nulls and re-index the array for storage (e.g., [path1, path2])
        $finalImagePaths = array_values(array_filter($uploadedImagePaths));

        // Create the product
        $product = Product::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'images' => $finalImagePaths, // Assign the array, model casting handles JSON encoding
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all(); // Fetch all categories for the dropdown
        // --- CHANGE HERE: Use the 'create' view for editing ---
        return view('admin.products.create', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'product_id' => 'required|string|unique:products,product_id,' . $product->id . '|max:255',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                // Images are now all nullable for update, as they can be replaced or cleared
                'images.0' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images.1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images.2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'images.3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'nullable|string',
                // Validation for clear checkboxes (though usually not needed, as their presence is enough)
                'clear_images.*' => 'nullable|boolean',
            ]);
        } catch (ValidationException $e) {
            throw $e;
        }

        // Get existing image paths (as an array, thanks to model casting)
        $currentImagePaths = $product->images ?? [];
        // Initialize an array to build the final list of image paths for the product
        $finalImagePaths = [];

        // We iterate for up to 4 image slots
        for ($i = 0; $i < 4; $i++) {
            $imageFile = $request->file('images.' . $i);
            $clearImage = $request->input('clear_images.' . $i); // Check if the 'remove' checkbox for this slot was ticked

            $oldImagePath = $currentImagePaths[$i] ?? null; // Get the path of the existing image for this slot

            if ($imageFile && $imageFile->isValid()) {
                // A new image is uploaded for this slot
                // 1. Delete the old image if it exists
                if ($oldImagePath) {
                    $relativePath = str_replace('/storage/', 'products/', $oldImagePath);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                }
                // 2. Store the new image
                $fileName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $path = $imageFile->storeAs('products', $fileName, 'public');
                $finalImagePaths[$i] = Storage::url($path); // Store the public URL
            } elseif ($clearImage) {
                // The 'remove' checkbox was ticked for this slot, and no new image was uploaded
                // 1. Delete the old image
                if ($oldImagePath) {
                    $relativePath = str_replace('/storage/', 'products/', $oldImagePath);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                }
                $finalImagePaths[$i] = null; // Set this slot to null
            } else {
                // No new image uploaded and 'remove' not ticked, so retain the old image for this slot
                $finalImagePaths[$i] = $oldImagePath;
            }
        }
        
        // Filter out any null values and re-index the array before saving
        $productImagesToSave = array_values(array_filter($finalImagePaths));

        // Update product details including the (potentially new) image paths
        $product->update([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'images' => $productImagesToSave, // Assign the array, model casting handles JSON encoding
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // NOTE: We REMOVED the image deletion loop.
            // With Soft Deletes, we keep the physical images so they still 
            // show up in Order History for previous customers.
            
            // This will now perform a "Soft Delete" (updates deleted_at column)
            // It will NOT trigger the Foreign Key error anymore.
            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');

        } catch (\Illuminate\Database\QueryException $e) {
            // Safety check: If Soft Deletes aren't working, catch the FK error
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Cannot delete this product because it is part of existing orders.');
            }
            throw $e;
        }
    }
}