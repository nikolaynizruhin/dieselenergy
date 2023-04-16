<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;

dataset('create_category', provider());
dataset('update_category', provider(2));

function provider(int $count = 1): array
{
    return [
        'Name is required' => [
            'name', fn () => validFields(['name' => null]),
        ],
        'Name cant be an integer' => [
            'name', fn () => validFields(['name' => 1]),
        ],
        'Name cant be more than 255 chars' => [
            'name', fn () => validFields(['name' => Str::random(256)]),
        ],
        'Name must be unique' => [
            'name', fn () => validFields(['name' => Category::factory()->create()->name]), $count,
        ],
        'Slug must be unique' => [
            'slug', fn () => validFields(['slug' => Category::factory()->create()->slug]), $count,
        ],
        'Slug is required' => [
            'slug', fn () => validFields(['slug' => null]),
        ],
        'Slug cant be an integer' => [
            'slug', fn () => validFields(['slug' => 1]),
        ],
        'Slug cant be more than 255 chars' => [
            'slug', fn () => validFields(['slug' => Str::random(256)]),
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Category::factory()->raw($overrides);
}
