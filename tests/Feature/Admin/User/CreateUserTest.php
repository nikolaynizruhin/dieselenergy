<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use HasValidation;

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
     *
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

    public function validationProvider()
    {
        return $this->provider(2);
    }

    /**
     * Get valid user fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields(array $overrides = []): array
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
