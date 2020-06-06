<?php

namespace Tests\Feature\Admin\Customer;

use App\Customer;
use App\User;
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
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.customers.create'))
            ->assertViewIs('admin.customers.create');
    }

    /** @test */
    public function guest_cant_create_customer()
    {
        $customer = factory(Customer::class)->raw();

        $this->post(route('admin.customers.store'), $customer)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_customer()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', 'Customer was created successfully!');

        $this->assertDatabaseHas('customers', $customer);
    }

    /** @test */
    public function user_cant_create_customer_without_name()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['name' => null]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_name()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['name' => 1]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['name' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_without_email()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['email' => null]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_integer_email()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['email' => 1]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_email_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['email' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_with_invalid_email()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['email' => 'invalid']);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_with_duplicated_email()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_without_phone()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['phone' => null]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_phone()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['phone' => 1]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_phone_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['phone' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_notes()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->raw(['notes' => 1]);

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('notes');
    }
}
