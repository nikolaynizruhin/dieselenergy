<?php

namespace Tests\Feature\Admin\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_users()
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_users()
    {
        [$admin, $user] = factory(User::class, 2)->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users')
            ->assertSee($admin->email)
            ->assertSee($user->email);
    }
}
