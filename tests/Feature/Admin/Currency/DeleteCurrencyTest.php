<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use Tests\TestCase;

class DeleteCurrencyTest extends TestCase
{
    /** @test */
    public function guest_cant_delete_currency()
    {
        $currency = Currency::factory()->create();

        $this->delete(route('admin.currencies.destroy', $currency))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_category()
    {
        $currency = Currency::factory()->create();

        $this->login()
            ->from(route('admin.currencies.index'))
            ->delete(route('admin.currencies.destroy', $currency))
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.deleted'));

        $this->assertDatabaseMissing('currencies', ['id' => $currency->id]);
    }
}
