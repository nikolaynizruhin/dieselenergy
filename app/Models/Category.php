<?php

namespace App\Models;

use App\Filters\Filterable;
use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug'])]
class Category extends Model
{
    /** @use HasFactory<CartFactory> */
    use Filterable, HasFactory;

    /**
     * Get the products for the category.
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
     */
    public function scopeWithProductCount(Builder $query): Builder
    {
        return $query->withCount(['products' => fn (Builder $query) => $query->active()]);
    }

    /**
     * Load product category attributes.
     */
    public function loadAttributes(Product $product): Category
    {
        return $this->load([
            'attributes.products' => fn ($query) => $query->where('product_id', $product->id),
        ]);
    }
}
