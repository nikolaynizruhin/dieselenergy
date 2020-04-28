<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_users()
    {
        factory(User::class)->create(['name' => 'John Doe']);

        $this->get(route('users.index', ['search' => 'john']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_search_users()
    {
        $john = factory(User::class)->create(['name' => 'John Doe']);
        $jane = factory(User::class)->create(['name' => 'Jane Doe']);

        $this->actingAs($john)
            ->get(route('users.index', ['search' => $jane->name]))
            ->assertSee($jane->email)
            ->assertDontSee($john->email);
    }
}
