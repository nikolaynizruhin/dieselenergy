<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
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
                'name', fn () => $this->validFields(['name' => Attribute::factory()->create()->name]), $count,
            ],
            'Measure cant be an integer' => [
                'measure', fn () => $this->validFields(['measure' => 1]),
            ],
            'Measure cant be more than 255 chars' => [
                'measure', fn () => $this->validFields(['measure' => Str::random(256)]),
            ],
        ];
    }

    /**
     * Get valid attribute fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Attribute::factory()->raw($overrides);
    }
}
