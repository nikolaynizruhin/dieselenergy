<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadCurrenciesTest extends TestCase
{
    /** @test */
    public function guest_cant_read_currencies(): void
    {
        $this->get(route('admin.currencies.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_currencies(): void
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
