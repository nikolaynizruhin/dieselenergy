<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];

    /**
     * Get the products for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * The attributes that belong to the model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class)
            ->using(Specification::class)
            ->withPivot('id', 'is_featured')
            ->withTimestamps();
    }

    /**
     * Scope a query with active product count.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithProductCount(Builder $query)
    {
        return $query->withCount(['products' => fn (Builder $query) => $query->active()]);
    }

    /**
     * Load product category attributes.
     *
     * @param  \App\Models\Product  $product
     * @return \App\Models\Category
     */
    public function loadAttributes(Product $product): Category
    {
        return $this->load([
            'attributes.products' => fn ($query) => $query->where('product_id', $product->id),
        ]);
    }
}
