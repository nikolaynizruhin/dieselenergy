<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;

dataset('create_cart', provider());
dataset('update_cart', provider(2));

function provider(int $count = 1): array
{
    return [
        'Quantity is required' => [
            'quantity', fn () => validFields(['quantity' => null]),
        ],
        'Quantity cant be a string' => [
            'quantity', fn () => validFields(['quantity' => 'string']),
        ],
        'Quantity cant be zero' => [
            'quantity', fn () => validFields(['quantity' => 0]),
        ],
        'Product is required' => [
            'product_id', fn () => validFields(['product_id' => null]),
        ],
        'Product cant be string' => [
            'product_id', fn () => validFields(['product_id' => 'string']),
        ],
        'Product must exists' => [
            'product_id', fn () => validFields(['product_id' => 10]),
        ],
        'Order is required' => [
            'order_id', fn () => validFields(['order_id' => null]),
        ],
        'Order cant be string' => [
            'order_id', fn () => validFields(['order_id' => 'string']),
        ],
        'Order must exists' => [
            'order_id', fn () => validFields(['order_id' => 10]),
        ],
        'Cart must be unique' => [
            'product_id', fn () => Cart::factory()->create()->toArray(), $count,
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Cart::factory()->raw($overrides);
}
