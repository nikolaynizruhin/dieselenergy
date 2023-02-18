<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;

trait HasValidation
{
    public static function provider(int $count = 1): array
    {
        return [
            'Quantity is required' => [
                'quantity', fn () => self::validFields(['quantity' => null]),
            ],
            'Quantity cant be a string' => [
                'quantity', fn () => self::validFields(['quantity' => 'string']),
            ],
            'Quantity cant be zero' => [
                'quantity', fn () => self::validFields(['quantity' => 0]),
            ],
            'Product is required' => [
                'product_id', fn () => self::validFields(['product_id' => null]),
            ],
            'Product cant be string' => [
                'product_id', fn () => self::validFields(['product_id' => 'string']),
            ],
            'Product must exists' => [
                'product_id', fn () => self::validFields(['product_id' => 10]),
            ],
            'Order is required' => [
                'order_id', fn () => self::validFields(['order_id' => null]),
            ],
            'Order cant be string' => [
                'order_id', fn () => self::validFields(['order_id' => 'string']),
            ],
            'Order must exists' => [
                'order_id', fn () => self::validFields(['order_id' => 10]),
            ],
            'Cart must be unique' => [
                'product_id', fn () => Cart::factory()->create()->toArray(), $count,
            ],
        ];
    }

    /**
     * Get valid cart fields.
     */
    private static function validFields(array $overrides = []): array
    {
        return Cart::factory()->raw($overrides);
    }
}
