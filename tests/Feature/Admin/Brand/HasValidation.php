<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;

trait HasValidation
{
    public function provider(int $count = 1): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Name must be unique' => [
                'name', fn () => $this->validFields(['name' => Brand::factory()->create()->name]), $count,
            ],
            'Currency is required' => [
                'currency_id', fn () => $this->validFields(['currency_id' => null]),
            ],
            'Currency cant be string' => [
                'currency_id', fn () => $this->validFields(['currency_id' => 'string']),
            ],
            'Currency must exists' => [
                'currency_id', fn () => $this->validFields(['currency_id' => 10]),
            ],
        ];
    }

    /**
     * Get valid brand fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Brand::factory()->raw($overrides);
    }
}
