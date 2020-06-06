<?php

namespace Tests\Feature\Admin\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_users()
    {
        factory(User::class)->create(['name' => 'John Doe']);

        $this->get(route('admin.users.index', ['search' => 'john']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_users()
    {
        $john = factory(User::class)->create(['name' => 'John Doe']);
        $jane = factory(User::class)->create(['name' => 'Jane Doe']);

        $this->actingAs($john)
            ->get(route('admin.users.index', ['search' => $jane->name]))
            ->assertSee($jane->email)
            ->assertDontSee($john->email);
    }
}
