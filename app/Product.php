<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Attributable, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'brand_id', 'category_id', 'is_active',
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
     * @param  null|array  $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filter)
    {
        collect($filter)->each(fn ($values, $id) => $query
            ->whereHas('attributes', fn (Builder $query) => $query
                ->where('attribute_id', $id)
                ->whereIn('value', $values)
            )
        );
    }

    /**
     * Get product default image.
     *
     * @return \App\Image|null
     */
    public function defaultImage()
    {
        return $this->images()->wherePivot('is_default', 1)->first();
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
