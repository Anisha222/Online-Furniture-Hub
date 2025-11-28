<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Add this import

class Product extends Model
{
    // 2. Add SoftDeletes to the use statement
    use HasFactory, SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'category_id',
        'description',
        'images',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'images' => 'array', // Crucial: Cast 'images' to an array
    ];

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the cart items for the product.
     *
     * @return HasMany
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for the product.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the first image path for the product.
     * This is an accessor to easily retrieve the first image from the 'images' array.
     * It ensures the path is relative to the 'storage/app/public' directory.
     */
    public function getFirstImagePathAttribute(): ?string
    {
        if (!empty($this->images) && is_array($this->images) && !empty($this->images[0])) {
            $path = $this->images[0];

            // 1. Clean up potential extra escaped quotes and 'V' prefix if data is malformed as seen in DB.
            // This is a robust attempt to clean the specific malformed data you have.
            $path = preg_replace('/^"V/', '', $path); // Remove initial "V (if present)
            $path = preg_replace('/^"/', '', $path);   // Remove initial " (if present)
            $path = rtrim($path, '"');                  // Remove trailing " (if present)

            // 2. Replace 'V' path separators with forward slashes
            $path = str_replace('V', '/', $path);
            // Also replace backslashes if any were correctly stored
            $path = str_replace('\\', '/', $path);


            // 3. Remove any leading 'storage/' or 'public/' that shouldn't be there
            $path = preg_replace('/^storage\//i', '', $path); // Case-insensitive
            $path = preg_replace('/^public\//i', '', $path);  // Case-insensitive

            // 4. Trim any extra leading/trailing slashes for consistency
            $path = trim($path, '/');

            // Final check to ensure it's not empty after cleaning
            if (!empty($path)) {
                return $path;
            }
        }
        return null; // Return null if no images are present or path is invalid
    }
}