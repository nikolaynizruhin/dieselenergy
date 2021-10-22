<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function guest_cant_visit_create_user_page()
    {
        $this->get(route('admin.users.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_user_page()
    {
        $this->login()
            ->get(route('admin.users.create'))
            ->assertViewIs('admin.users.create');
    }

    /** @test */
    public function guest_cant_create_user()
    {
        $this->post(route('admin.users.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_user()
    {
        $this->login()
            ->post(route('admin.users.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', trans('user.created'));

        $user = User::firstWhere('email', $fields['email']);

        $this->assertEquals($user->name, $fields['name']);
        $this->assertEquals($user->email, $fields['email']);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /** @test */
    public function user_cant_create_user_without_name()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['name' => null]))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_integer_name()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['name' => 1]))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_name_more_than_255_chars()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields([
                'name' => str_repeat('a', 256),
            ]))->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_without_email()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['email' => null]))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_integer_email()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['email' => 1]))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_email_more_than_255_chars()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields([
                'email' => str_repeat('a', 256),
            ]))->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_invalid_email()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['email' => 'invalid']))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_duplicated_email()
    {
        $user = User::factory()->create();

        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['email' => $user->email]))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 2);
    }

    /** @test */
    public function user_cant_create_user_without_password()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['password' => null]))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('password');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_integer_password()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields([
                'password' => 12345678,
                'password_confirmation' => 12345678,
            ]))->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('password');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_with_password_less_than_8_chars()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields([
                'password' => 'small',
                'password_confirmation' => 'small',
            ]))->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('password');

        $this->assertDatabaseCount('users', 1);
    }

    /** @test */
    public function user_cant_create_user_without_password_confirmation()
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $this->validFields(['password_confirmation' => null]))
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors('password');

        $this->assertDatabaseCount('users', 1);
    }

    /**
     * Get valid user fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return array_merge([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $overrides);
    }
}
