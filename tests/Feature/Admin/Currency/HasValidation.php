<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;

trait HasValidation
{
    public function provider(int $count = 1): array
    {
        return [
            'Code cant be an integer' => [
                'code', fn () => $this->validFields(['code' => 1]),
            ],
            'Code is required' => [
                'code', fn () => $this->validFields(['code' => null]),
            ],
            'Code must be 3 chars' => [
                'code', fn () => $this->validFields(['code' => 'us']),
            ],
            'Code must be unique' => [
                'code', fn () => $this->validFields(['code' => Currency::factory()->create()->code]), $count,
            ],
            'Rate is required' => [
                'rate', fn () => $this->validFields(['rate' => null]),
            ],
            'Rate cant be a string' => [
                'rate', fn () => $this->validFields(['rate' => 'string']),
            ],
            'Rate cant be less than zero' => [
                'rate', fn () => $this->validFields(['rate' => -1]),
            ],
            'Symbol is required' => [
                'symbol', fn () => $this->validFields(['symbol' => null]),
            ],
            'Symbol cant be an integer' => [
                'symbol', fn () => $this->validFields(['symbol' => 1]),
            ],
            'Symbol must be unique' => [
                'symbol', fn () => $this->validFields(['symbol' => Currency::factory()->create()->symbol]), $count,
            ],
        ];
    }

    /**
     * Get valid currency fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Currency::factory()->raw($overrides);
    }
}
