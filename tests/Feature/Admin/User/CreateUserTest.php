<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
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

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_user_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.users.create'))
            ->post(route('admin.users.store'), $data())
            ->assertRedirect(route('admin.users.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('users', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Email is required' => [
                'email', fn () => $this->validFields(['email' => null]),
            ],
            'Email cant be an integer' => [
                'email', fn () => $this->validFields(['email' => 1]),
            ],
            'Email cant be more than 255 chars' => [
                'email', fn () => $this->validFields(['email' => Str::random(256)]),
            ],
            'Email must be valid' => [
                'email', fn () => $this->validFields(['email' => 'invalid']),
            ],
            'Email must be unique' => [
                'email', fn () => $this->validFields(['email' => User::factory()->create()->email]), 2,
            ],
            'Password is required' => [
                'password', fn () => $this->validFields(['password' => null]),
            ],
            'Password confirmation is required' => [
                'password', fn () => $this->validFields(['password_confirmation' => null]),
            ],
            'Password cant be an integer' => [
                'password', fn () => $this->validFields(['password' => 12345678, 'password_confirmation' => 12345678]),
            ],
            'Password cant be less than 8 chars' => [
                'password', fn () => $this->validFields(['password' => 'small', 'password_confirmation' => 'small']),
            ],
        ];
    }

    /**
     * Get valid user fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        $user = User::factory()->make();

        return array_merge([
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $overrides);
    }
}
