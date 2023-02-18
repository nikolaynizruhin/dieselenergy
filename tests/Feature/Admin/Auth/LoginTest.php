<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function user_can_view_login_page(): void
    {
        $this->get(route('admin.login'))
            ->assertSuccessful()
            ->assertViewIs('admin.auth.login');
    }

    /** @test */
    public function authenticated_user_cant_view_login_page(): void
    {
        $this->login()
            ->get(route('admin.login'))
            ->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create();

        $this->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_login_with_remember_me(): void
    {
        $user = User::factory()->create();

        $this->post(route('admin.login'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => 'on',
        ])->assertRedirect(route('admin.dashboard'))
            ->assertCookie(
                Auth::guard()->getRecallerName(),
                $user->id.'|'.$user->getRememberToken().'|'.$user->password
            );

        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_login_with_invalid_data(callable $data): void
    {
        $this->from(route('admin.login'))
            ->post(route('admin.login'), $data())
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        $this->assertGuest();
    }

    public static function validationProvider(): array
    {
        return [
            'Email must exists' => [
                fn () => ['email' => 'missing@example.com', 'password' => 'password'],
            ],
            'Password must be correct' => [
                fn () => ['email' => User::factory()->create()->email, 'password' => 'incorrect'],
            ],
        ];
    }

    /** @test */
    public function user_can_logout(): void
    {
        $this->login()
            ->post(route('admin.logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test */
    public function unauthenticated_user_cant_logout(): void
    {
        $this->post(route('admin.logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test */
    public function user_cant_make_more_than_five_attempts_in_a_minute(): void
    {
        Carbon::setTestNow(now()->startOfDay());

        $user = User::factory()->create();

        foreach (range(0, 5) as $attempt) {
            $response = $this->from(route('admin.login'))
                ->post(route('admin.login'), [
                    'email' => $user->email,
                    'password' => 'incorrect',
                ]);
        }

        $response->assertRedirect(route('admin.login'))
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
