<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Support\Str;

dataset('create_customer', provider());
dataset('update_customer', provider(2));

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
        'Email is required' => [
            'email', fn () => validFields(['email' => null]),
        ],
        'Email cant be an integer' => [
            'email', fn () => validFields(['email' => 1]),
        ],
        'Email cant be more than 255 chars' => [
            'email', fn () => validFields(['email' => Str::random(256)]),
        ],
        'Email must be valid' => [
            'email', fn () => validFields(['email' => 'invalid']),
        ],
        'Email must be unique' => [
            'email', fn () => validFields(['email' => Customer::factory()->create()->email]), $count,
        ],
        'Phone is required' => [
            'phone', fn () => validFields(['phone' => null]),
        ],
        'Phone must have valid format' => [
            'phone', fn () => validFields(['phone' => 0631234567]),
        ],
        'Notes cant be an integer' => [
            'notes', fn () => validFields(['notes' => 1]),
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Customer::factory()->raw($overrides);
}
