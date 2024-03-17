<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;

class Specification extends Pivot
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attribute_category';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_featured' => 'boolean'];
    }

    /**
     * Get featured attribute ids by category.
     */
    public static function featured(Category $category): Collection
    {
        return self::where([
            'category_id' => $category->id,
            'is_featured' => 1,
        ])->pluck('attribute_id');
    }

    /**
     * Get the attribute that owns the specification.
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get the category that owns the specification.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Toggle feature.
     */
    public function toggle(): bool
    {
        return $this->update(['is_featured' => ! $this->is_featured]);
    }

    /**
     * Get validation rules for category.
     *
     * @param  int  $categoryId
     */
    public static function getValidationRules($categoryId, array|string $rules): array
    {
        return self::query()
            ->where('category_id', $categoryId)
            ->pluck('attribute_id')
            ->mapWithKeys(fn ($id) => ['attributes.'.$id => $rules])
            ->all();
    }
}
