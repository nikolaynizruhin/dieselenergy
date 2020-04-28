<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_users()
    {
        $this->get(route('users.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_users()
    {
        [$admin, $user] = factory(User::class, 2)->create();

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertSuccessful()
            ->assertViewIs('users.index')
            ->assertSee($admin->email)
            ->assertSee($user->email);
    }
}
