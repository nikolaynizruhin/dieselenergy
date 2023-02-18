<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SortCustomersTest extends TestCase
{
    /** @test */
    public function guest_cant_sort_customers(): void
    {
        $this->get(route('admin.customers.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_customers_by_name_ascending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        $this->login()
            ->get(route('admin.customers.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$adam->name, $tom->name]);
    }

    /** @test */
    public function admin_can_sort_customers_by_name_descending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        $this->login()
            ->get(route('admin.customers.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$tom->name, $adam->name]);
    }

    /** @test */
    public function admin_can_sort_customers_by_email_ascending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['email' => 'adam@example.com'],
                ['email' => 'tom@example.com'],
            ))->create();

        $this->login()
            ->get(route('admin.customers.index', ['sort' => 'email']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$adam->email, $tom->email]);
    }

    /** @test */
    public function admin_can_sort_customers_by_email_descending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['email' => 'adam@example.com'],
                ['email' => 'tom@example.com'],
            ))->create();

        $this->login()
            ->get(route('admin.customers.index', ['sort' => '-email']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$tom->email, $adam->email]);
    }

    /** @test */
    public function admin_can_sort_customers_by_phone_ascending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['phone' => '+380631234567'],
                ['phone' => '+380632234567'],
            ))->create();

        $this->login()
            ->get(route('admin.customers.index', ['sort' => 'phone']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$adam->phone, $tom->phone]);
    }

    /** @test */
    public function admin_can_sort_customers_by_phone_descending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['phone' => '+380631234567'],
                ['phone' => '+380632234567'],
            ))->create();

        $this->login()
            ->get(route('admin.customers.index', ['sort' => '-phone']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$tom->phone, $adam->phone]);
    }
}
