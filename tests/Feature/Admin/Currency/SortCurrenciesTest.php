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

    /**
     * Euro currency.
     *
     * @var \App\Models\Currency
     */
    private $euro;

    /**
     * Dollar currency.
     *
     * @var \App\Models\Currency
     */
    private $dollar;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->euro, $this->dollar] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['code' => 'EUR'],
                ['code' => 'USD'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_currencies()
    {
        $this->get(route('admin.currencies.index', ['sort' => 'code']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_currencies_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.currencies.index', ['sort' => 'code']))
            ->assertSuccessful()
            ->assertViewIs('admin.currencies.index')
            ->assertViewHas('currencies')
            ->assertSeeInOrder([$this->euro->code, $this->dollar->code]);
    }

    /** @test */
    public function admin_can_sort_currencies_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.currencies.index', ['sort' => '-code']))
            ->assertSuccessful()
            ->assertViewIs('admin.currencies.index')
            ->assertViewHas('currencies')
            ->assertSeeInOrder([$this->dollar->code, $this->euro->code]);
    }
}
