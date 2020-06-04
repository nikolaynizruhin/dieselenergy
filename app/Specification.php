<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Specification extends MorphPivot
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
    protected $table = 'attributables';

    /**
     * Get the attribute that owns the specification.
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
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
        return self::where([
            'attributable_id' => $categoryId,
            'attributable_type' => Category::class,
        ])->pluck('attribute_id')
            ->mapWithKeys(fn ($id) => [
                'attributes.'.$id => $rules,
            ])->all();
    }
}
