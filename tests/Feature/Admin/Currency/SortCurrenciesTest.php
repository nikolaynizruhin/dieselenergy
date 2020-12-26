<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortCurrenciesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_sort_currencies()
    {
        $this->get(route('admin.currencies.index', ['sort' => 'code']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_currencies_by_code_ascending()
    {
        $user = User::factory()->create();

        [$euro, $dollar] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['code' => 'EUR'],
                ['code' => 'USD'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.currencies.index', ['sort' => 'code']))
            ->assertSuccessful()
            ->assertViewIs('admin.currencies.index')
            ->assertViewHas('currencies')
            ->assertSeeInOrder([$euro->code, $dollar->code]);
    }

    /** @test */
    public function admin_can_sort_currencies_by_code_descending()
    {
        $user = User::factory()->create();

        [$euro, $dollar] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['code' => 'EUR'],
                ['code' => 'USD'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.currencies.index', ['sort' => '-code']))
            ->assertSuccessful()
            ->assertViewIs('admin.currencies.index')
            ->assertViewHas('currencies')
            ->assertSeeInOrder([$dollar->code, $euro->code]);
    }

    /** @test */
    public function admin_can_sort_currencies_by_rate_ascending()
    {
        $user = User::factory()->create();

        [$dollar, $euro] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['rate' => 30.0000],
                ['rate' => 28.0000],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.currencies.index', ['sort' => 'rate']))
            ->assertSuccessful()
            ->assertViewIs('admin.currencies.index')
            ->assertViewHas('currencies')
            ->assertSeeInOrder([$euro->rate, $dollar->rate]);
    }

    /** @test */
    public function admin_can_sort_currencies_by_rate_descending()
    {
        $user = User::factory()->create();

        [$dollar, $euro] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['rate' => 30.0000],
                ['rate' => 28.0000],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.currencies.index', ['sort' => '-rate']))
            ->assertSuccessful()
            ->assertViewIs('admin.currencies.index')
            ->assertViewHas('currencies')
            ->assertSeeInOrder([$dollar->rate, $euro->rate]);
    }
}
