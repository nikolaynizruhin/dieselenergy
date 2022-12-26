<?php

namespace Tests\Feature\Admin\Customer;

use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_customer_page()
    {
        $this->get(route('admin.customers.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_customer_page()
    {
        $this->login()
            ->get(route('admin.customers.create'))
            ->assertViewIs('admin.customers.create');
    }

    /** @test */
    public function guest_cant_create_customer()
    {
        $this->post(route('admin.customers.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_customer()
    {
        $this->login()
            ->post(route('admin.customers.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.created'));

        $this->assertDatabaseHas('customers', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_customer_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.customers.create'))
            ->post(route('admin.customers.store'), $data())
            ->assertRedirect(route('admin.customers.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('customers', $count);
    }

    public function validationProvider(): array
    {
        return $this->provider();
    }
}
