<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;

trait HasValidation
{
    public static function provider(): array
    {
        return [
            'Notes cant be an integer' => [
                'notes', fn () => self::validFields(['notes' => 1]),
            ],
            'Customer is required' => [
                'customer_id', fn () => self::validFields(['customer_id' => null]),
            ],
            'Customer cant be string' => [
                'customer_id', fn () => self::validFields(['customer_id' => 'string']),
            ],
            'Customer must exists' => [
                'customer_id', fn () => self::validFields(['customer_id' => 10]),
            ],
            'Status is required' => [
                'status', fn () => self::validFields(['status' => null]),
            ],
            'Status cant be an integer' => [
                'status', fn () => self::validFields(['status' => 1]),
            ],
        ];
    }

    /**
     * Get valid order fields.
     */
    private static function validFields(array $overrides = []): array
    {
        return Order::factory()->raw($overrides);
    }
}
