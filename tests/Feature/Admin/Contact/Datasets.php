<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;

dataset('create_contact', provider());
dataset('update_contact', provider(2));

function provider(int $count = 1): array
{
    return [
        'Message cant be an integer' => [
            'message', fn () => validFields(['message' => 1]),
        ],
        'Customer is required' => [
            'customer_id', fn () => validFields(['customer_id' => null]),
        ],
        'Customer cant be string' => [
            'customer_id', fn () => validFields(['customer_id' => 'string']),
        ],
        'Customer must exists' => [
            'customer_id', fn () => validFields(['customer_id' => 10]),
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Contact::factory()->raw($overrides);
}
