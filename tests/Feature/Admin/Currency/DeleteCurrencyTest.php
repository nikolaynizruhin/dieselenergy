<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCurrencyTest extends TestCase
{
    use RefreshDatabase;

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
        $user = User::factory()->create();
        $currency = Currency::factory()->create();

        $this->actingAs($user)
            ->from(route('admin.currencies.index'))
            ->delete(route('admin.currencies.destroy', $currency))
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.deleted'));

        $this->assertDatabaseMissing('currencies', ['id' => $currency->id]);
    }
}
