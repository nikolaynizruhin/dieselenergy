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
        $currency = Currency::factory()->raw();

        $this->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_currency()
    {
        $currency = Currency::factory()->raw();

        $this->login()
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.created'));

        $this->assertDatabaseHas('currencies', $currency);
    }

    /** @test */
    public function user_cant_create_currency_without_code()
    {
        $currency = Currency::factory()->raw(['code' => null]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_with_integer_code()
    {
        $currency = Currency::factory()->raw(['code' => 1]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_with_code_different_than_3_chars()
    {
        $currency = Currency::factory()->raw(['code' => 'US']);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_with_existing_code()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => $currency->code]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $stub)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_create_currency_without_rate()
    {
        $currency = Currency::factory()->raw(['rate' => null]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('rate');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_with_string_rate()
    {
        $currency = Currency::factory()->raw(['rate' => 'string']);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('rate');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_with_rate_less_than_0()
    {
        $currency = Currency::factory()->raw([
            'rate' => $this->faker->randomFloat(4, -10, -1),
        ]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('rate');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_without_symbol()
    {
        $currency = Currency::factory()->raw(['symbol' => null]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('symbol');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_with_integer_symbol()
    {
        $currency = Currency::factory()->raw(['symbol' => 1]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('symbol');

        $this->assertDatabaseCount('currencies', 0);
    }

    /** @test */
    public function user_cant_create_currency_with_existing_symbol()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => $currency->symbol]);

        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $stub)
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors('symbol');

        $this->assertDatabaseCount('currencies', 1);
    }
}
