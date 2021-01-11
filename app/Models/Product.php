<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'model', 'slug', 'description', 'price', 'brand_id', 'category_id', 'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope a query with featured attributes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithFeaturedAttributes($query, $category)
    {
        return $query->with([
            'attributes' => fn ($query) => $query->wherePivotIn(
                'attribute_id',
                Specification::featured($category),
            ),
        ]);
    }

    /**
     * Scope a query with default image.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDefaultImage($query)
    {
        return $query->with([
            'images' => fn ($query) => $query->wherePivot('is_default', 1),
        ]);
    }

    /**
     * Get product default image.
     *
     * @return \App\Models\Image|null
     */
    public function defaultImage()
    {
        return $this->images()
            ->wherePivot('is_default', 1)
            ->first();
    }

    /**
     * Price in UAH.
     *
     * @return float
     */
    public function getUahPriceAttribute()
    {
        return round($this->price * $this->brand->currency->rate / 100);
    }

    /**
     * Formatted price.
     *
     * @return string
     */
    public function getDecimalPriceAttribute()
    {
        return number_format($this->price / 100, 2, '.', '');
    }

    /**
     * Get the brand of the product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the category of the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The orders that belong to the product.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->using(Cart::class)
            ->withPivot('id', 'quantity')
            ->withTimestamps();
    }

    /**
     * The images that belong to the product.
     */
    public function images()
    {
        return $this->belongsToMany(Image::class)
            ->using(Media::class)
            ->withPivot('id', 'is_default')
            ->withTimestamps();
    }

    /**
     * The attributes that belong to the model.
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->withPivot('id', 'value')
            ->withTimestamps();
    }
}
