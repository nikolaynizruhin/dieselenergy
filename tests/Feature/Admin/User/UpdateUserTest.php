<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_user_page()
    {
        $user = User::factory()->create();

        $this->get(route('admin.users.edit', $user))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_user_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.users.edit', $user))
            ->assertViewIs('admin.users.edit')
            ->assertViewHas('user', $user);
    }

    /** @test */
    public function guest_cant_update_user()
    {
        $user = User::factory()->create();

        $this->put(route('admin.users.update', $user), [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_user()
    {
        $admin = User::factory()->create();
        $user = User::factory()->make();

        $this->actingAs($admin)
            ->put(route('admin.users.update', $admin), [
                'name' => $user->name,
                'email' => $user->email,
            ])->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', trans('user.updated'));

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function user_cant_update_user_without_name()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'email' => $this->faker->email,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_user_with_integer_name()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => 1,
                'email' => $this->faker->email,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_user_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => str_repeat('a', 256),
                'email' => $this->faker->email,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_user_without_email()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => $this->faker->name,
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_integer_email()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => $this->faker->name,
                'email' => 1,
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_email_more_than_255_chars()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => $this->faker->name,
                'email' => str_repeat('a', 256),
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_invalid_email()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => $this->faker->name,
                'email' => 'invalid',
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_duplicated_email()
    {
        [$admin, $user] = User::factory()->count(2)->create();

        $this->actingAs($admin)
            ->put(route('admin.users.update', $admin), [
                'name' => $this->faker->name,
                'email' => $user->email,
            ])->assertSessionHasErrors('email');
    }
}
