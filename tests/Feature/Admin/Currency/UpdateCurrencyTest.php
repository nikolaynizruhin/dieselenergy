<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use App\Models\User;
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
        $user = User::factory()->create();
        $currency = Currency::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.updated'));

        $this->assertDatabaseHas('currencies', $stub);
    }

    /** @test */
    public function user_cant_update_currency_without_code()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => null]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_update_currency_with_integer_code()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => 1]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_update_currency_with_code_different_than_3_chars()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => 'US']);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_update_currency_with_existing_code()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $existing = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => $existing->code]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_update_currency_without_rate()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['rate' => null]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('rate');
    }

    /** @test */
    public function user_cant_update_currency_with_string_rate()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['rate' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('rate');
    }

    /** @test */
    public function user_cant_update_currency_with_rate_less_than_0()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw([
            'rate' => $this->faker->randomFloat($nbMaxDecimals = 4, $min = -10, $max = -1),
        ]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('rate');
    }

    /** @test */
    public function user_cant_update_currency_without_symbol()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => null]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('symbol');
    }

    /** @test */
    public function user_cant_update_currency_with_integer_symbol()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => 1]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('symbol');
    }

    /** @test */
    public function user_cant_update_currency_with_existing_symbol()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $existing = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => $existing->symbol]);

        $this->actingAs($user)
            ->put(route('admin.currencies.update', $currency), $stub)
            ->assertSessionHasErrors('symbol');
    }
}
