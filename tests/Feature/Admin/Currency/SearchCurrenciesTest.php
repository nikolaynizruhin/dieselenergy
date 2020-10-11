<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCurrenciesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_currencies()
    {
        $currency = Currency::factory()->create();

        $this->get(route('admin.currencies.index', ['search' => $currency->code]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_currencies()
    {
        $user = User::factory()->create();

        [$usd, $eur, $rub] = Currency::factory()
            ->count(3)
            ->state(new Sequence(
                ['code' => 'USD'],
                ['code' => 'EUR'],
                ['code' => 'RUB'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.currencies.index', ['search' => 'R']))
            ->assertSeeInOrder([$eur->code, $rub->code])
            ->assertDontSee($usd->code);
    }
}
