<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCurrenciesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_currencies()
    {
        $this->get(route('admin.currencies.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_currencies()
    {
        [$eur, $usd] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['code' => 'EUR'],
                ['code' => 'USD']
            ))->create();

        $this->login()
            ->get(route('admin.currencies.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.currencies.index')
            ->assertViewHas('currencies')
            ->assertSeeInOrder([$eur->code, $usd->code]);
    }
}
