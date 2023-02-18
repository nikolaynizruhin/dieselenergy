<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Support\Str;

trait HasValidation
{
    public static function provider(int $count = 1): array
    {
        return [
            'Name is required' => [
                'name', fn () => self::validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => self::validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => self::validFields(['name' => Str::random(256)]),
            ],
            'Email is required' => [
                'email', fn () => self::validFields(['email' => null]),
            ],
            'Email cant be an integer' => [
                'email', fn () => self::validFields(['email' => 1]),
            ],
            'Email cant be more than 255 chars' => [
                'email', fn () => self::validFields(['email' => Str::random(256)]),
            ],
            'Email must be valid' => [
                'email', fn () => self::validFields(['email' => 'invalid']),
            ],
            'Email must be unique' => [
                'email', fn () => self::validFields(['email' => Customer::factory()->create()->email]), $count,
            ],
            'Phone is required' => [
                'phone', fn () => self::validFields(['phone' => null]),
            ],
            'Phone must have valid format' => [
                'phone', fn () => self::validFields(['phone' => 0631234567]),
            ],
            'Notes cant be an integer' => [
                'notes', fn () => self::validFields(['notes' => 1]),
            ],
        ];
    }

    /**
     * Get valid customer fields.
     */
    private static function validFields(array $overrides = []): array
    {
        return Customer::factory()->raw($overrides);
    }
}
