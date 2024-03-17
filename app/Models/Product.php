<?php

namespace App\Models;

use App\Filters\Filterable;
use App\Support\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute as AttributeCast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use Filterable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'model', 'slug', 'description', 'price', 'brand_id', 'category_id', 'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope a query with featured attributes.
     */
    public function scopeWithFeaturedAttributes(Builder $query, Category $category): Builder
    {
        return $query->with([
            'attributes' => fn ($query) => $query->wherePivotIn(
                'attribute_id',
                Specification::featured($category),
            ),
        ]);
    }

    /**
     * Load product attributes.
     */
    public function loadAttributes(): Product
    {
        return $this->load(['attributes' => fn ($query) => $query->whereNotNull('value')]);
    }

    /**
     * Scope a query with default image.
     */
    public function scopeWithDefaultImage(Builder $query): Builder
    {
        return $query->with([
            'images' => fn ($query) => $query->wherePivot('is_default', 1),
        ]);
    }

    /**
     * Get product default image.
     */
    public function defaultImage(): ?Image
    {
        return $this->images()
            ->wherePivot('is_default', 1)
            ->first();
    }

    /**
     * Product price.
     */
    protected function price(): AttributeCast
    {
        return new AttributeCast(fn ($value) => new Money($value, $this->brand->currency));
    }

    /**
     * Get the brand of the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the category of the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The orders that belong to the product.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->using(Cart::class)
            ->withPivot('id', 'quantity')
            ->withTimestamps();
    }

    /**
     * The images that belong to the product.
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class)
            ->using(Media::class)
            ->withPivot('id', 'is_default')
            ->withTimestamps();
    }

    /**
     * The attributes that belong to the model.
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class)
            ->withPivot('id', 'value')
            ->withTimestamps();
    }

    /**
     * Get list of recommended products.
     */
    public function recommendations(): Collection
    {
        return self::query()
            ->active()
            ->withDefaultImage()
            ->with(['category', 'brand.currency'])
            ->where('id', '<>', $this->id)
            ->where('category_id', $this->category_id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }
}
