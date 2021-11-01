<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Specification;

trait HasValidation
{
    public function provider($count = 1): array
    {
        return [
            'Category is required' => [
                'category_id', fn () => $this->validFields(['category_id' => null]),
            ],
            'Category cant be string' => [
                'category_id', fn () => $this->validFields(['category_id' => 'string']),
            ],
            'Category must exists' => [
                'category_id', fn () => $this->validFields(['category_id' => 10]),
            ],
            'Attribute is required' => [
                'attribute_id', fn () => $this->validFields(['attribute_id' => null]),
            ],
            'Attribute cant be string' => [
                'attribute_id', fn () => $this->validFields(['attribute_id' => 'string']),
            ],
            'Attribute must exists' => [
                'attribute_id', fn () => $this->validFields(['attribute_id' => 10]),
            ],
            'Specification must be unique' => [
                'attribute_id', fn () => Specification::factory()->create()->toArray(), $count,
            ],
        ];
    }

    /**
     * Get valid specification fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Specification::factory()->raw($overrides);
    }
}
