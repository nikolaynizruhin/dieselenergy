<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;

trait HasValidation
{
    public function provider($count = 1): array
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
                'name', fn () => $this->validFields(['name' => Category::factory()->create()->name]), $count,
            ],
            'Slug must be unique' => [
                'slug', fn () => $this->validFields(['slug' => Category::factory()->create()->slug]), $count,
            ],
            'Slug is required' => [
                'slug', fn () => $this->validFields(['slug' => null]),
            ],
            'Slug cant be an integer' => [
                'slug', fn () => $this->validFields(['slug' => 1]),
            ],
            'Slug cant be more than 255 chars' => [
                'slug', fn () => $this->validFields(['slug' => Str::random(256)]),
            ],
        ];
    }

    /**
     * Get valid category fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Category::factory()->raw($overrides);
    }
}
