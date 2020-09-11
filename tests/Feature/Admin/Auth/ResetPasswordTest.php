<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_password_reset_page()
    {
        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $this->get(route('admin.password.reset', $token))
            ->assertSuccessful()
            ->assertViewIs('admin.auth.passwords.reset')
            ->assertViewHas('token', $token);
    }

    /** @test */
    public function authenticated_user_can_view_password_reset_page()
    {
        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $this->actingAs($user)
            ->get(route('admin.password.reset', $token))
            ->assertSuccessful()
            ->assertViewIs('admin.auth.passwords.reset')
            ->assertViewHas('token', $token);
    }

    /** @test */
    public function user_can_reset_password_with_valid_token()
    {
        Event::fake();

        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $this->post('/admin/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(
            PasswordReset::class,
            fn ($event) => $event->user->id === $user->id
        );
    }

    /** @test */
    public function user_cannot_reset_password_with_invalid_token()
    {
        $user = User::factory()->create();

        $this->from(route('admin.password.reset', 'invalid'))
            ->post('/admin/password/reset', [
                'token' => 'invalid',
                'email' => $user->email,
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])->assertRedirect(route('admin.password.reset', 'invalid'));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_reset_password_without_providing_new_password()
    {
        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $this->from(route('admin.password.reset', $token))
            ->post('/admin/password/reset', [
                'token' => $token,
                'email' => $user->email,
                'password' => '',
                'password_confirmation' => '',
            ])->assertRedirect(route('admin.password.reset', $token))
            ->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_reset_password_without_providing_email()
    {
        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $this->from(route('admin.password.reset', $token))
            ->post('/admin/password/reset', [
                'token' => $token,
                'email' => '',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])->assertRedirect(route('admin.password.reset', $token))
            ->assertSessionHasErrors('email');

        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
        $this->assertGuest();
    }
}
