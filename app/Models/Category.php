<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug', // Added 'slug' to be mass assignable
    ];
    
    /**
     * Get the products for the category.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the route key for the model.
     * This allows Route Model Binding to use the 'slug' instead of 'id'.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}