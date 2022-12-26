<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /** @test */
    public function guest_can_visit_forgot_password_page()
    {
        $this->get(route('admin.password.request'))
            ->assertSuccessful()
            ->assertViewIs('admin.auth.passwords.email');
    }

    /** @test */
    public function user_can_visit_forgot_password_page()
    {
        $this->login()
            ->get(route('admin.password.request'))
            ->assertSuccessful()
            ->assertViewIs('admin.auth.passwords.email');
    }

    /** @test */
    public function user_receives_email_with_password_reset_link()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('admin.password.email'), ['email' => $user->email]);

        $token = DB::table('password_resets')->where(['email' => $user->email])->first();

        $this->assertNotNull($token);

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            fn ($notification, $channels) => Hash::check($notification->token, $token->token) === true
        );
    }

    /** @test */
    public function user_does_not_receive_email_when_not_registered()
    {
        Notification::fake();

        $user = User::factory()->make();

        $this->from(route('admin.password.request'))
            ->post(route('admin.password.email'), [
                'email' => $user->email,
            ])->assertRedirect(route('admin.password.request'))
            ->assertSessionHasErrors('email');

        Notification::assertNotSentTo($user, ResetPassword::class);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_get_reset_password_email_with_invalid_email($email)
    {
        $this->from(route('admin.password.request'))
            ->post(route('admin.password.email'), ['email' => $email])
            ->assertRedirect(route('admin.password.request'))
            ->assertSessionHasErrors('email');
    }

    public function validationProvider(): array
    {
        return [
            'Email is required' => [null],
            'Email must be valid' => ['invalid'],
        ];
    }
}
