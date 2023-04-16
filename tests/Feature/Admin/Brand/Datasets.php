<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;

dataset('create_brand', provider());
dataset('update_brand', provider(2));

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
            'name', fn () => validFields(['name' => Brand::factory()->create()->name]), $count,
        ],
        'Currency is required' => [
            'currency_id', fn () => validFields(['currency_id' => null]),
        ],
        'Currency cant be string' => [
            'currency_id', fn () => validFields(['currency_id' => 'string']),
        ],
        'Currency must exists' => [
            'currency_id', fn () => validFields(['currency_id' => 10]),
        ],
    ];
}
function validFields(array $overrides = []): array
{
    return Brand::factory()->raw($overrides);
}
