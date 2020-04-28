<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_user_page()
    {
        $user = factory(User::class)->create();

        $this->get(route('users.edit', $user))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_update_user_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('users.edit', $user))
            ->assertViewIs('users.edit')
            ->assertViewHas('user', $user);
    }

    /** @test */
    public function guest_cant_update_user()
    {
        $user = factory(User::class)->create();

        $this->put(route('users.update', $user), [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_update_user()
    {
        $admin = factory(User::class)->create();
        $user = factory(User::class)->make();

        $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'name' => $user->name,
                'email' => $user->email,
            ])->assertRedirect(route('users.index'))
            ->assertSessionHas('status', 'User was updated successfully!');

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function user_cant_update_user_without_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('users.update', $user), [
                'email' => $this->faker->email,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_user_with_integer_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => 1,
                'email' => $this->faker->email,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_user_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => str_repeat('a', 256),
                'email' => $this->faker->email,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_user_without_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => $this->faker->name,
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_integer_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => $this->faker->name,
                'email' => 1,
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_email_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => $this->faker->name,
                'email' => str_repeat('a', 256),
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_invalid_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('users.update', $user), [
                'name' => $this->faker->name,
                'email' => 'invalid',
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_update_user_with_duplicated_email()
    {
        [$admin, $user] = factory(User::class, 2)->create();

        $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'name' => $this->faker->name,
                'email' => $user->email,
            ])->assertSessionHasErrors('email');
    }
}
