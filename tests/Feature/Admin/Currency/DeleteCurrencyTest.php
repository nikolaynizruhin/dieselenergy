<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use Tests\TestCase;

class DeleteCurrencyTest extends TestCase
{
    /**
     * Currency.
     *
     * @var \App\Models\Currency
     */
    private $currency;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->currency = Currency::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_currency()
    {
        $this->delete(route('admin.currencies.destroy', $this->currency))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_category()
    {
        $this->login()
            ->from(route('admin.currencies.index'))
            ->delete(route('admin.currencies.destroy', $this->currency))
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.deleted'));

        $this->assertDeleted($this->currency);
    }
}
