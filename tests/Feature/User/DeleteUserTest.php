<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_user()
    {
        $user = factory(User::class)->create();

        $this->delete(route('users.destroy', $user))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_user()
    {
        [$admin, $user] = factory(User::class, 2)->create();

        $this->actingAs($admin)
            ->from(route('users.index'))
            ->delete(route('users.destroy', $user))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('status', 'User was deleted successfully!');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
