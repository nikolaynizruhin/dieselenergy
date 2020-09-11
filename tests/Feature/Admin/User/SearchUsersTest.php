<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_users()
    {
        User::factory()->create(['name' => 'John Doe']);

        $this->get(route('admin.users.index', ['search' => 'john']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_users()
    {
        [$admin, $john, $jane, $tom] = User::factory()
            ->count(4)
            ->state(new Sequence(
                ['name' => 'Admin'],
                ['name' => 'John Doe'],
                ['name' => 'Jane Doe'],
                ['name' => 'Tom Jo'],
            ))->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$jane->email, $john->email])
            ->assertDontSee($tom->email);
    }
}
