<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Specification extends Pivot
{
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Get featured attribute ids by category.
     *
     * @param  \App\Category  $category
     * @return array
     */
    public static function featuredAttributes($category)
    {
        return self::where([
            'category_id' => $category->id,
            'is_featured' => 1,
        ])->pluck('attribute_id');
    }

    /**
     * Get the attribute that owns the specification.
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get the category that owns the specification.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get validation rules for category.
     *
     * @param  int  $categoryId
     * @param  string|array  $rules
     * @return array
     */
    public static function getValidationRules($categoryId, $rules)
    {
        return self::where('category_id', $categoryId)
            ->pluck('attribute_id')
            ->mapWithKeys(fn ($id) => [
                'attributes.'.$id => $rules,
            ])->all();
    }
}
