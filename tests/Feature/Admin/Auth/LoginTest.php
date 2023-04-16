<?php

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

test('user can view login page', function () {
    $this->get(route('admin.login'))
        ->assertSuccessful()
        ->assertViewIs('admin.auth.login');
});

test('authenticated user cant view login page', function () {
    $this->login()
        ->get(route('admin.login'))
        ->assertRedirect(route('admin.dashboard'));
});

test('user can login with correct credentials', function () {
    $user = User::factory()->create();

    $this->post(route('admin.login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
});

test('user can login with remember me', function () {
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
});

test('user cant login with invalid data', function (callable $data) {
    $this->from(route('admin.login'))
        ->post(route('admin.login'), $data())
        ->assertRedirect(route('admin.login'))
        ->assertSessionHasErrors('email');

    $this->assertTrue(session()->hasOldInput('email'));
    $this->assertFalse(session()->hasOldInput('password'));

    $this->assertGuest();
})->with([
    'Email must exists' => [
        fn () => ['email' => 'missing@example.com', 'password' => 'password'],
    ],
    'Password must be correct' => [
        fn () => ['email' => User::factory()->create()->email, 'password' => 'incorrect'],
    ],
]);

test('user can logout', function () {
    $this->login()
        ->post(route('admin.logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});

test('unauthenticated user cant logout', function () {
    $this->post(route('admin.logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});

test('user cant make more than five attempts in a minute', function () {
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
});
