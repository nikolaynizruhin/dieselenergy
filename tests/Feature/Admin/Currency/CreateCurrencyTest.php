<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCurrencyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_currency_page()
    {
        $this->get(route('admin.currencies.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_currency_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $currency = Currency::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.created'));

        $this->assertDatabaseHas('currencies', $currency);
    }

    /** @test */
    public function user_cant_create_currency_without_code()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw(['code' => null]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_create_currency_with_integer_code()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw(['code' => 1]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_create_currency_with_code_different_than_3_chars()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw(['code' => 'US']);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_create_currency_with_existing_code()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['code' => $currency->code]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $stub)
            ->assertSessionHasErrors('code');
    }

    /** @test */
    public function user_cant_create_currency_without_rate()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw(['rate' => null]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('rate');
    }

    /** @test */
    public function user_cant_create_currency_with_string_rate()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw(['rate' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('rate');
    }

    /** @test */
    public function user_cant_create_currency_with_rate_less_than_0()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw([
            'rate' => $this->faker->randomFloat($nbMaxDecimals = 4, $min = -10, $max = -1),
        ]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('rate');
    }

    /** @test */
    public function user_cant_create_currency_without_symbol()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw(['symbol' => null]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('symbol');
    }

    /** @test */
    public function user_cant_create_currency_with_integer_symbol()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->raw(['symbol' => 1]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $currency)
            ->assertSessionHasErrors('symbol');
    }

    /** @test */
    public function user_cant_create_currency_with_existing_symbol()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        $stub = Currency::factory()->raw(['symbol' => $currency->symbol]);

        $this->actingAs($user)
            ->post(route('admin.currencies.store'), $stub)
            ->assertSessionHasErrors('symbol');
    }
}
