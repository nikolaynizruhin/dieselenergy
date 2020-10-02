<?php

namespace App\Models;

use App\Attributable;
use App\HasSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Attributable, HasFactory, HasSearch;

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
     * Scope a query to a filter term.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Support\Collection  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {
        $filters->each(fn ($values, $id) => $query
            ->whereHas('attributes', fn (Builder $query) => $query
                ->where('attribute_id', $id)
                ->whereIn('value', $values)
            )
        );
    }

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
    public function scopeWithFeatured($query, $category)
    {
        return $query->with([
            'attributes' => fn ($query) => $query->wherePivotIn(
                'attribute_id',
                Specification::featured($category),
            ),
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
}
