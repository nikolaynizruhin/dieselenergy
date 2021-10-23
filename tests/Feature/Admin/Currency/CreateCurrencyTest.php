<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCurrencyTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function guest_cant_visit_create_currency_page()
    {
        $this->get(route('admin.currencies.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_currency_page()
    {
        $this->login()
            ->get(route('admin.currencies.create'))
            ->assertViewIs('admin.currencies.create');
    }

    /** @test */
    public function guest_cant_create_currency()
    {
        $this->post(route('admin.currencies.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_currency()
    {
        $this->login()
            ->post(route('admin.currencies.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.created'));

        $this->assertDatabaseHas('currencies', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_currency_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $data())
            ->assertRedirect(route('admin.currencies.create'))
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
                'code', fn () => $this->validFields(['code' => Currency::factory()->create()->code]), 1,
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
                'symbol', fn () => $this->validFields(['symbol' => Currency::factory()->create()->symbol]), 1,
            ],
        ];
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Currency::factory()->raw($overrides);
    }
}
