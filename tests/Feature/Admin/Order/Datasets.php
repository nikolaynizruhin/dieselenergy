<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

dataset('create_order', provider());
dataset('update_order', provider() + totalProvider());

function provider(): array
{
    return [
        'Notes cant be an integer' => [
            'notes', fn () => validFields(['notes' => 1]),
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
        'Status is required' => [
            'status', fn () => validFields(['status' => null]),
        ],
        'Status cant be an integer' => [
            'status', fn () => validFields(['status' => 1]),
        ],
    ];
}

function totalProvider(): array
{
    return [
        'Total is required' => [
            'total', fn () => validFields(['total' => null]),
        ],
        'Total cant be string' => [
            'total', fn () => validFields(['total' => 'string']),
        ],
        'Total cant be negative' => [
            'total', fn () => validFields(['total' => -1]),
        ],
    ];
}


function validFields(array $overrides = []): array
{
    return Order::factory()->raw($overrides);
}
