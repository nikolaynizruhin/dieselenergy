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
     * Get validation rules for category.
     *
     * @param  int  $categoryId
     * @return array
     */
    public static function getValidationRules($categoryId)
    {
        return self::where([
            'attributable_id' => $categoryId,
            'attributable_type' => Category::class,
        ])->pluck('attribute_id')
            ->mapWithKeys(fn ($id) => [
                'attributes.'.$id => 'required|max:255',
            ])->all();
    }
}
