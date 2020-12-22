<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortCustomersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Customer Adam.
     *
     * @var \App\Models\Customer
     */
    private $adam;

    /**
     * Customer Tom.
     *
     * @var \App\Models\Customer
     */
    private $tom;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->adam, $this->tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_customers()
    {
        $this->get(route('admin.customers.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_customers_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$this->adam->name, $this->tom->name]);
    }

    /** @test */
    public function admin_can_sort_customers_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$this->tom->name, $this->adam->name]);
    }
}
