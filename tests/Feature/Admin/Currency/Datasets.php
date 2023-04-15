<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;

dataset('create_currency', provider());
dataset('update_currency', provider(2));

function provider(int $count = 1): array
{
    return [
        'Code cant be an integer' => [
            'code', fn () => validFields(['code' => 1]),
        ],
        'Code is required' => [
            'code', fn () => validFields(['code' => null]),
        ],
        'Code must be 3 chars' => [
            'code', fn () => validFields(['code' => 'us']),
        ],
        'Code must be unique' => [
            'code', fn () => validFields(['code' => Currency::factory()->create()->code]), $count,
        ],
        'Rate is required' => [
            'rate', fn () => validFields(['rate' => null]),
        ],
        'Rate cant be a string' => [
            'rate', fn () => validFields(['rate' => 'string']),
        ],
        'Rate cant be less than zero' => [
            'rate', fn () => validFields(['rate' => -1]),
        ],
        'Symbol is required' => [
            'symbol', fn () => validFields(['symbol' => null]),
        ],
        'Symbol cant be an integer' => [
            'symbol', fn () => validFields(['symbol' => 1]),
        ],
        'Symbol must be unique' => [
            'symbol', fn () => validFields(['symbol' => Currency::factory()->create()->symbol]), $count,
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Currency::factory()->raw($overrides);
}
