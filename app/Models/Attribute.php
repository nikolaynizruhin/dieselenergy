<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute as AttributeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    /** @use HasFactory<\Database\Factories\AttributeFactory> */
    use Filterable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'measure',
    ];

    /**
     * Get the attribute's field.
     */
    protected function field(): AttributeCast
    {
        return new AttributeCast(
            fn () => $this->measure
                ? $this->name.', '.$this->measure
                : $this->name
        );
    }

    /**
     * The categories that belong to the attribute.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->using(Specification::class)
            ->withPivot('id', 'is_featured')
            ->withTimestamps();
    }

    /**
     * The products that belong to the attribute.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('id', 'value')
            ->withTimestamps();
    }
}
