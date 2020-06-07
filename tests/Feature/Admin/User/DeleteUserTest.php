<?php

namespace Tests\Feature\Admin\User;

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

        $this->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_user()
    {
        [$admin, $user] = factory(User::class, 2)->create();

        $this->actingAs($admin)
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', trans('user.deleted'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
