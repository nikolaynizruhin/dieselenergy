<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateUserPasswordTest extends TestCase
{
    /**
     * Product.
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
    public function guest_cant_update_user_password()
    {
        $this->put(route('admin.users.password.update', $this->user), $this->validFields())
            ->assertRedirect(route('admin.login'));

        $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
    }

    /** @test */
    public function user_can_update_user_password()
    {
        $this->actingAs($this->user)
            ->from(route('admin.users.password.update', $this->user))
            ->put(route('admin.users.password.update', $this->user), $this->validFields())
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', trans('user.password.updated'));

        $this->assertTrue(Hash::check('new-password', $this->user->fresh()->password));
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_user_with_invalid_password($data)
    {
        $this->actingAs($this->user)
            ->from(route('admin.users.password.update', $this->user))
            ->put(route('admin.users.password.update', $this->user), $data())
            ->assertRedirect(route('admin.users.password.update', $this->user))
            ->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
    }

    public function validationProvider(): array
    {
        return [
            'Password is required' => [
                fn () => $this->validFields(['password' => null]),
            ],
            'Password confirmation is required' => [
                fn () => $this->validFields(['password_confirmation' => null]),
            ],
            'Password cant be an integer' => [
                fn () => $this->validFields(['password' => 12345678, 'password_confirmation' => 12345678]),
            ],
            'Password cant be less than 8 chars' => [
                fn () => $this->validFields(['password' => 'small', 'password_confirmation' => 'small']),
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
        return array_merge([
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ], $overrides);
    }
}
