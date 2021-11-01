<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;

trait HasValidation
{
    public function provider(): array
    {
        return [
            'Product is required' => [
                'product_id', fn () => $this->validFields(['product_id' => null]),
            ],
            'Product cant be string' => [
                'product_id', fn () => $this->validFields(['product_id' => 'string']),
            ],
            'Product must exists' => [
                'product_id', fn () => $this->validFields(['product_id' => 10]),
            ],
            'Image is required' => [
                'image_id', fn () => $this->validFields(['image_id' => null]),
            ],
            'Image cant be string' => [
                'image_id', fn () => $this->validFields(['image_id' => 'string']),
            ],
            'Image must exists' => [
                'image_id', fn () => $this->validFields(['image_id' => 10]),
            ],
        ];
    }

    /**
     * Get valid media fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Media::factory()->raw($overrides);
    }
}
