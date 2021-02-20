<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
        $customer = Customer::factory()->raw();

        $this->post(route('admin.customers.store'), $customer)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_customer()
    {
        $customer = Customer::factory()->raw();

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.created'));

        $this->assertDatabaseHas('customers', $customer);
    }

    /** @test */
    public function user_cant_create_customer_without_name()
    {
        $customer = Customer::factory()->raw(['name' => null]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_name()
    {
        $customer = Customer::factory()->raw(['name' => 1]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_with_name_more_than_255_chars()
    {
        $customer = Customer::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_without_email()
    {
        $customer = Customer::factory()->raw(['email' => null]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_integer_email()
    {
        $customer = Customer::factory()->raw(['email' => 1]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_email_more_than_255_chars()
    {
        $customer = Customer::factory()->raw(['email' => str_repeat('a', 256)]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_with_invalid_email()
    {
        $customer = Customer::factory()->raw(['email' => 'invalid']);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_with_duplicated_email()
    {
        $customer = Customer::factory()->create();

        $this->login()
            ->post(route('admin.customers.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_without_phone()
    {
        $customer = Customer::factory()->raw(['phone' => null]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_incorrect_phone_format()
    {
        $customer = Customer::factory()->raw(['phone' => 80631234567]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_notes()
    {
        $customer = Customer::factory()->raw(['notes' => 1]);

        $this->login()
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('notes');
    }
}
