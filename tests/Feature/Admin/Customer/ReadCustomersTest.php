<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCustomersTest extends TestCase
{


    /** @test */
    public function guest_cant_read_customers()
    {
        $this->get(route('admin.customers.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_customers()
    {
        [$jane, $john] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()->subDay()],
                ['created_at' => now()]
            ))->create();

        $this->login()
            ->get(route('admin.customers.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$john->email, $jane->email]);
    }
}
