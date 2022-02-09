<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    /**
     * User.
     *
     * @var \App\Models\User
     */
    private $user;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_user()
    {
        $this->delete(route('admin.users.destroy', $this->user))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_user()
    {
        $this->login()
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.destroy', $this->user))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', trans('user.deleted'));

        $this->assertModelMissing($this->user);
    }
}
