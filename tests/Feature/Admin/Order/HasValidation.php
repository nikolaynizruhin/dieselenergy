<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;

trait HasValidation
{
    public function provider(): array
    {
        return [
            'Notes cant be an integer' => [
                'notes', fn () => $this->validFields(['notes' => 1]),
            ],
            'Customer is required' => [
                'customer_id', fn () => $this->validFields(['customer_id' => null]),
            ],
            'Customer cant be string' => [
                'customer_id', fn () => $this->validFields(['customer_id' => 'string']),
            ],
            'Customer must exists' => [
                'customer_id', fn () => $this->validFields(['customer_id' => 10]),
            ],
            'Status is required' => [
                'status', fn () => $this->validFields(['status' => null]),
            ],
            'Status cant be an integer' => [
                'status', fn () => $this->validFields(['status' => 1]),
            ],
        ];
    }

    /**
     * Get valid order fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Order::factory()->raw($overrides);
    }
}
