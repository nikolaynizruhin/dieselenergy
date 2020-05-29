<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_page()
    {
        $this->get(route('login'))
            ->assertSuccessful()
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function authenticated_user_cant_view_login_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_login_with_remember_me()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ])->assertRedirect(route('dashboard'))
            ->assertCookie(
                Auth::guard()->getRecallerName(),
                $user->id.'|'.$user->getRememberToken().'|'.$user->password
            );

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cant_login_with_incorrect_password()
    {
        $user = factory(User::class)->create();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'incorrect',
            ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    /** @test */
    public function user_cant_login_with_missing_email()
    {
        $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'missing@example.com',
                'password' => 'incorrect',
            ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    /** @test */
    public function user_can_logout()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test */
    public function unauthenticated_user_cant_logout()
    {
        $this->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test */
    public function user_cant_make_more_than_five_attempts_in_a_minute()
    {
        Carbon::setTestNow(now()->startOfDay());

        $user = factory(User::class)->create();

        foreach (range(0, 5) as $attempt) {
            $response = $this->from(route('login'))
                ->post(route('login'), [
                    'email' => $user->email,
                    'password' => 'incorrect',
                ]);
        }

        $response->assertRedirect(route('login'))
            ->assertSessionHasErrors([
                'email' => Lang::get('auth.throttle', [
                    'seconds' => config('auth.passwords.users.throttle'),
                    'minutes' => ceil(config('auth.passwords.users.throttle') / 60),
                ]),
            ]);

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }
}
