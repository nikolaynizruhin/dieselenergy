<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use Tests\TestCase;

class UpdateCurrencyTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Currency
     */
    private $currency;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->currency = Currency::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_edit_currency_page()
    {
        $this->get(route('admin.currencies.edit', $this->currency))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_edit_currency_page()
    {
        $this->login()
            ->get(route('admin.currencies.edit', $this->currency))
            ->assertViewIs('admin.currencies.edit');
    }

    /** @test */
    public function guest_cant_update_currency()
    {
        $this->put(route('admin.currencies.update', $this->currency), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_currency()
    {
        $this->login()
            ->put(route('admin.currencies.update', $this->currency), $fields = $this->validFields())
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.updated'));

        $this->assertDatabaseHas('currencies', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_currency_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.currencies.edit', $this->currency))
            ->put(route('admin.currencies.update', $this->currency), $data())
            ->assertRedirect(route('admin.currencies.edit', $this->currency))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('currencies', $count);
    }

    public function validationProvider(): array
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
                'code', fn () => $this->validFields(['code' => Currency::factory()->create()->code]), 2,
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
                'symbol', fn () => $this->validFields(['symbol' => Currency::factory()->create()->symbol]), 2,
            ],
        ];
    }

    /**
     * Get valid currency fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Currency::factory()->raw($overrides);
    }
}
