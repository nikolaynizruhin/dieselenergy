<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Illuminate\Support\Str;

dataset('create_attribute', provider());
dataset('update_attribute', provider(2));

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
            'name', fn () => validFields(['name' => Attribute::factory()->create()->name]), $count,
        ],
        'Measure cant be an integer' => [
            'measure', fn () => validFields(['measure' => 1]),
        ],
        'Measure cant be more than 255 chars' => [
            'measure', fn () => validFields(['measure' => Str::random(256)]),
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Attribute::factory()->raw($overrides);
}
