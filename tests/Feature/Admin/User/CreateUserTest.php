<?php

namespace Tests\Feature\Admin\User;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_user_page()
    {
        $this->get(route('admin.users.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_user_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.users.create'))
            ->assertViewIs('admin.users.create');
    }

    /** @test */
    public function guest_cant_create_user()
    {
        $this->post(route('admin.users.store'), [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_user()
    {
        $admin = factory(User::class)->create();
        $stub = factory(User::class)->make();

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => $stub->name,
                'email' => $stub->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', trans('user.created'));

        $user = User::firstWhere('email', $stub->email);

        $this->assertEquals($user->name, $stub->name);
        $this->assertEquals($user->email, $stub->email);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /** @test */
    public function user_cant_create_user_without_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'email' => $this->faker->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_user_with_integer_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => 1,
                'email' => $this->faker->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_user_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => str_repeat('a', 256),
                'email' => $this->faker->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_user_without_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_integer_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => 1,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_email_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => str_repeat('a', 256),
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_invalid_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => 'invalid',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_with_duplicated_email()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_create_user_without_password()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cant_create_user_with_integer_password()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => 12345678,
                'password_confirmation' => 12345678,
            ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cant_create_user_with_password_less_than_8_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => 'small',
                'password_confirmation' => 'small',
            ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cant_create_user_without_password_confirmation()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => 'password',
            ])->assertSessionHasErrors('password');
    }
}
