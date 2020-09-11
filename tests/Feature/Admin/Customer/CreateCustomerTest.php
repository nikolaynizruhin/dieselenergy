<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\User;
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
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.create'))
            ->assertViewIs('admin.customers.create');
    }

    /** @test */
    public function guest_cant_create_customer()
    {
        $customer = Customer::factory()->make()->toArray();

        $this->post(route('admin.customers.store'), $customer)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make()->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.created'));

        $this->assertDatabaseHas('customers', $customer);
    }

    /** @test */
    public function user_cant_create_customer_without_name()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['name' => null])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_name()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['name' => 1])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['name' => str_repeat('a', 256)])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_customer_without_email()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['email' => null])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_integer_email()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['email' => 1])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_email_more_than_255_chars()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['email' => str_repeat('a', 256)])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_with_invalid_email()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['email' => 'invalid'])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_with_duplicated_email()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer->toArray())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_customer_without_phone()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['phone' => null])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_phone()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['phone' => 1])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_phone_more_than_255_chars()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['phone' => str_repeat('a', 256)])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function user_cant_create_customer_with_integer_notes()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make(['notes' => 1])->toArray();

        $this->actingAs($user)
            ->post(route('admin.customers.store'), $customer)
            ->assertSessionHasErrors('notes');
    }
}
