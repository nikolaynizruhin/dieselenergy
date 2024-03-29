<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

test('user can view password reset page', function () {
    $user = User::factory()->create();

    $token = Password::broker()->createToken($user);

    $this->get(route('admin.password.reset', $token))
        ->assertSuccessful()
        ->assertViewIs('admin.auth.passwords.reset')
        ->assertViewHas('token', $token);
});

test('authenticated user can view password reset page', function () {
    $user = User::factory()->create();

    $token = Password::broker()->createToken($user);

    $this->actingAs($user)
        ->get(route('admin.password.reset', $token))
        ->assertSuccessful()
        ->assertViewIs('admin.auth.passwords.reset')
        ->assertViewHas('token', $token);
});

test('user can reset password with valid token', function () {
    Event::fake();

    $user = User::factory()->create();

    $token = Password::broker()->createToken($user);

    $this->post('/admin/password/reset', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->assertRedirect(route('admin.dashboard'));

    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
    $this->assertAuthenticatedAs($user);

    Event::assertDispatched(
        PasswordReset::class,
        fn ($event) => $event->user->id === $user->id
    );
});

test('user cannot reset password with invalid token', function () {
    $user = User::factory()->create();

    $this->fromRoute('admin.password.reset', 'invalid')
        ->post('/admin/password/reset', [
            'token' => 'invalid',
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('admin.password.reset', 'invalid'));

    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
    $this->assertGuest();
});

test('user cannot reset password without providing new password', function () {
    $user = User::factory()->create();

    $token = Password::broker()->createToken($user);

    $this->fromRoute('admin.password.reset', $token)
        ->post('/admin/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => '',
        ])->assertRedirect(route('admin.password.reset', $token))
        ->assertSessionHasErrors('password');

    expect(session()->hasOldInput('email'))->toBeTrue();
    expect(session()->hasOldInput('password'))->toBeFalse();
    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
    $this->assertGuest();
});

test('user cannot reset password without providing email', function () {
    $user = User::factory()->create();

    $token = Password::broker()->createToken($user);

    $this->fromRoute('admin.password.reset', $token)
        ->post('/admin/password/reset', [
            'token' => $token,
            'email' => '',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('admin.password.reset', $token))
        ->assertSessionHasErrors('email');

    expect(session()->hasOldInput('password'))->toBeFalse();
    expect($user->fresh()->email)->toEqual($user->email);
    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
    $this->assertGuest();
});
