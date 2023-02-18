<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;
use Tests\TestCase;

class UpdateCurrencyTest extends TestCase
{
    use HasValidation;

    /**
     * Currency.
     */
    private Currency $currency;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->currency = Currency::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_edit_currency_page(): void
    {
        $this->get(route('admin.currencies.edit', $this->currency))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_edit_currency_page(): void
    {
        $this->login()
            ->get(route('admin.currencies.edit', $this->currency))
            ->assertViewIs('admin.currencies.edit');
    }

    /** @test */
    public function guest_cant_update_currency(): void
    {
        $this->put(route('admin.currencies.update', $this->currency), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_currency(): void
    {
        $this->login()
            ->put(route('admin.currencies.update', $this->currency), $fields = self::validFields())
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.updated'));

        $this->assertDatabaseHas('currencies', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_currency_with_invalid_data(string $field, callable $data, int $count = 1): void
    {
        $this->login()
            ->from(route('admin.currencies.edit', $this->currency))
            ->put(route('admin.currencies.update', $this->currency), $data())
            ->assertRedirect(route('admin.currencies.edit', $this->currency))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('currencies', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider(2);
    }
}
