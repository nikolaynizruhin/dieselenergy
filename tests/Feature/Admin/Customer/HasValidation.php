<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Support\Str;

trait HasValidation
{
    public function provider(int $count = 1): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Email is required' => [
                'email', fn () => $this->validFields(['email' => null]),
            ],
            'Email cant be an integer' => [
                'email', fn () => $this->validFields(['email' => 1]),
            ],
            'Email cant be more than 255 chars' => [
                'email', fn () => $this->validFields(['email' => Str::random(256)]),
            ],
            'Email must be valid' => [
                'email', fn () => $this->validFields(['email' => 'invalid']),
            ],
            'Email must be unique' => [
                'email', fn () => $this->validFields(['email' => Customer::factory()->create()->email]), $count,
            ],
            'Phone is required' => [
                'phone', fn () => $this->validFields(['phone' => null]),
            ],
            'Phone must have valid format' => [
                'phone', fn () => $this->validFields(['phone' => 0631234567]),
            ],
            'Notes cant be an integer' => [
                'notes', fn () => $this->validFields(['notes' => 1]),
            ],
        ];
    }

    /**
     * Get valid customer fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
    {
        return Customer::factory()->raw($overrides);
    }
}
