<?php

namespace Tests\Feature\Admin\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUserPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_update_user_password()
    {
        $user = factory(User::class)->create();

        $this->put(route('admin.users.password.update', $user), [
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_user_password()
    {
        $admin = factory(User::class)->create();

        $this->actingAs($admin)
            ->put(route('admin.users.password.update', $admin), [
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', 'User password was updated successfully!');

        $this->assertTrue(Hash::check('new-password', $admin->fresh()->password));
    }

    /** @test */
    public function user_cant_update_user_without_password()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('admin.users.password.update', $user), [
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cant_update_user_with_integer_password()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('admin.users.password.update', $user), [
                'password' => 12345678,
                'password_confirmation' => 12345678,
            ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cant_update_user_with_password_less_than_8_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('admin.users.password.update', $user), [
                'password' => 'small',
                'password_confirmation' => 'small',
            ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cant_update_user_without_password_confirmation()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('admin.users.password.update', $user), [
                'password' => 'password',
            ])->assertSessionHasErrors('password');
    }
}