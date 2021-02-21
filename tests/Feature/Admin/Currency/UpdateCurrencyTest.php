<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCurrencyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_edit_currency_page()
    {
        $currency = Currency::factory()->create();

        $this->get(route('admin.currencies.edit', $currency))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_edit_currency_page()
    {
        $currency = Currency::factory()->create();

        $this->login()
            ->get(route('admin.currencies.edit', $currency))
            ->assertViewIs('admin.currencies.edit');
    }

    /** @test */
    public function guest_cant_update_currency()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw();

        $this->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_currency()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw();

        $this->login()
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.updated'));

        $this->assertDatabaseHas('currencies', $stub);
    }

    /** @test */
    public function user_cant_update_currency_without_code()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => null]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_with_integer_code()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => 1]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_with_code_different_than_3_chars()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => 'US']);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_with_existing_code()
    {
        $currency = Currency::factory()->create();
        $existing = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => $existing->code]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('currencies', 2);
    }

    /** @test */
    public function user_cant_update_currency_without_rate()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['rate' => null]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('rate');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_with_string_rate()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['rate' => 'string']);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('rate');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_with_rate_less_than_0()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw([
            'rate' => $this->faker->randomFloat($nbMaxDecimals = 4, $min = -10, $max = -1),
        ]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('rate');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_without_symbol()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => null]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('symbol');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_with_integer_symbol()
    {
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => 1]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('symbol');

        $this->assertDatabaseCount('currencies', 1);
    }

    /** @test */
    public function user_cant_update_currency_with_existing_symbol()
    {
        $currency = Currency::factory()->create();
        $existing = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => $existing->symbol]);

        $this->login()
            ->from(route('admin.currencies.edit', $currency))
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.edit', $currency))
            ->assertSessionHasErrors('symbol');

        $this->assertDatabaseCount('currencies', 2);
    }
}
