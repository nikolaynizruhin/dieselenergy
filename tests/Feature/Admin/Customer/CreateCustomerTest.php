<?php

namespace Tests\Feature\Admin\Customer;

use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_customer_page(): void
    {
        $this->get(route('admin.customers.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_customer_page(): void
    {
        $this->login()
            ->get(route('admin.customers.create'))
            ->assertViewIs('admin.customers.create');
    }

    /** @test */
    public function guest_cant_create_customer(): void
    {
        $this->post(route('admin.customers.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_customer(): void
    {
        $this->login()
            ->post(route('admin.customers.store'), $fields = self::validFields())
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.created'));

        $this->assertDatabaseHas('customers', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_customer_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.customers.create'))
            ->post(route('admin.customers.store'), $data())
            ->assertRedirect(route('admin.customers.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('customers', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider();
    }
}
