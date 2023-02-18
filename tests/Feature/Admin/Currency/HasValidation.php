<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;

trait HasValidation
{
    public static function provider(int $count = 1): array
    {
        return [
            'Code cant be an integer' => [
                'code', fn () => self::validFields(['code' => 1]),
            ],
            'Code is required' => [
                'code', fn () => self::validFields(['code' => null]),
            ],
            'Code must be 3 chars' => [
                'code', fn () => self::validFields(['code' => 'us']),
            ],
            'Code must be unique' => [
                'code', fn () => self::validFields(['code' => Currency::factory()->create()->code]), $count,
            ],
            'Rate is required' => [
                'rate', fn () => self::validFields(['rate' => null]),
            ],
            'Rate cant be a string' => [
                'rate', fn () => self::validFields(['rate' => 'string']),
            ],
            'Rate cant be less than zero' => [
                'rate', fn () => self::validFields(['rate' => -1]),
            ],
            'Symbol is required' => [
                'symbol', fn () => self::validFields(['symbol' => null]),
            ],
            'Symbol cant be an integer' => [
                'symbol', fn () => self::validFields(['symbol' => 1]),
            ],
            'Symbol must be unique' => [
                'symbol', fn () => self::validFields(['symbol' => Currency::factory()->create()->symbol]), $count,
            ],
        ];
    }

    /**
     * Get valid currency fields.
     */
    private static function validFields(array $overrides = []): array
    {
        return Currency::factory()->raw($overrides);
    }
}
