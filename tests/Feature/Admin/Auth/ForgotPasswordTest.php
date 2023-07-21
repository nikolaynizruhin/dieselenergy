<?php

use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

test('guest can visit forgot password page', function () {
    $this->get(route('admin.password.request'))
        ->assertSuccessful()
        ->assertViewIs('admin.auth.passwords.email');
});

test('user can visit forgot password page', function () {
    $this->login()
        ->get(route('admin.password.request'))
        ->assertSuccessful()
        ->assertViewIs('admin.auth.passwords.email');
});

test('user receives email with password reset link', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('admin.password.email'), ['email' => $user->email]);

    $token = DB::table('password_reset_tokens')->where(['email' => $user->email])->first();

    expect($token)->not->toBeNull();

    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        fn ($notification, $channels) => Hash::check($notification->token, $token->token) === true
    );
});

test('user does not receive email when not registered', function () {
    Notification::fake();

    $user = User::factory()->make();

    $this->from(route('admin.password.request'))
        ->post(route('admin.password.email'), [
            'email' => $user->email,
        ])->assertRedirect(route('admin.password.request'))
        ->assertSessionHasErrors('email');

    Notification::assertNotSentTo($user, ResetPassword::class);
});

test('user cant get reset password email with invalid email', function ($email) {
    $this->from(route('admin.password.request'))
        ->post(route('admin.password.email'), ['email' => $email])
        ->assertRedirect(route('admin.password.request'))
        ->assertSessionHasErrors('email');
})->with([
    'Email is required' => [null],
    'Email must be valid' => ['invalid'],
]);
