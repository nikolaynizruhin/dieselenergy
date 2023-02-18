<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;

trait HasValidation
{
    public static function validationProvider(): array
    {
        return [
            'Message cant be an integer' => [
                'message', fn () => self::validFields(['message' => 1]),
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
        ];
    }

    /**
     * Get valid contact fields.
     */
    private static function validFields(array $overrides = []): array
    {
        return Contact::factory()->raw($overrides);
    }
}
