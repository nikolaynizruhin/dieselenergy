<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCustomerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_customer_page()
    {
        $customer = Customer::factory()->create();

        $this->get(route('admin.customers.edit', $customer))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_customer_page()
    {

        $customer = Customer::factory()->create();

        $this->login()
            ->get(route('admin.customers.edit', $customer))
            ->assertViewIs('admin.customers.edit');
    }

    /** @test */
    public function guest_cant_update_customer()
    {
        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw();

        $this->put(route('admin.customers.update', $customer), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_customer()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw();

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.updated'));

        $this->assertDatabaseHas('customers', $stub);
    }

    /** @test */
    public function user_cant_update_customer_without_name()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['name' => null]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_customer_with_integer_name()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['name' => 1]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_customer_with_name_more_than_255_chars()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_customer_without_email()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['email' => null]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_integer_email()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['email' => 1]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_email_more_than_255_chars()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['email' => str_repeat('a', 256)]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_customer_with_invalid_email()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['email' => 'invalid']);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_customer_with_duplicated_email()
    {

        $customer = Customer::factory()->create();
        $existed = Customer::factory()->create();

        $this->login()
            ->put(route('admin.customers.update', $customer), $existed->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_customer_without_phone()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['phone' => null]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_update_customer_with_incorrect_phone_format()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['phone' => 80631234567]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_update_customer_with_integer_notes()
    {

        $customer = Customer::factory()->create();
        $stub = Customer::factory()->raw(['notes' => 1]);

        $this->login()
            ->put(route('admin.customers.update', $customer), $stub)
            ->assertSessionHasErrors('notes');
    }
}
