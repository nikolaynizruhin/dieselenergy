<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCustomersTest extends TestCase
{


    /** @test */
    public function guest_cant_search_customers()
    {
        Customer::factory()->create(['name' => 'John Doe']);

        $this->get(route('admin.customers.index', ['search' => 'john']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_customers()
    {
        [$john, $jane, $tom] = Customer::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'John Doe', 'created_at' => now()->subDay()],
                ['name' => 'Jane Doe'],
                ['name' => 'Tom Jo'],
            ))->create();

        $this->login()
            ->get(route('admin.customers.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$jane->email, $john->email])
            ->assertDontSee($tom->email);
    }
}
