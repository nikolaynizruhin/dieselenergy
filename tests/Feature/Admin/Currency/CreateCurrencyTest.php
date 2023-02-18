<?php

namespace Tests\Feature\Admin\Currency;

use Tests\TestCase;

class CreateCurrencyTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_currency_page(): void
    {
        $this->get(route('admin.currencies.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_currency_page(): void
    {
        $this->login()
            ->get(route('admin.currencies.create'))
            ->assertViewIs('admin.currencies.create');
    }

    /** @test */
    public function guest_cant_create_currency(): void
    {
        $this->post(route('admin.currencies.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_currency(): void
    {
        $this->login()
            ->post(route('admin.currencies.store'), $fields = self::validFields())
            ->assertRedirect(route('admin.currencies.index'))
            ->assertSessionHas('status', trans('currency.created'));

        $this->assertDatabaseHas('currencies', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_currency_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.currencies.create'))
            ->post(route('admin.currencies.store'), $data())
            ->assertRedirect(route('admin.currencies.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('currencies', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider();
    }
}
