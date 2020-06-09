<?php

namespace Tests\Feature\Admin\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

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
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get(route('admin.password.request'))
            ->assertSuccessful()
            ->assertViewIs('admin.auth.passwords.email');
    }

    /** @test */
    public function user_cant_get_reset_password_email_without_email()
    {
        $this->from(route('admin.password.request'))
            ->post(route('admin.password.email'))
            ->assertRedirect(route('admin.password.request'))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cant_get_reset_password_email_with_invalid_email()
    {
        $this->from(route('admin.password.request'))
            ->post(route('admin.password.email'), [
                'email' => 'invalid',
            ])->assertRedirect(route('admin.password.request'))
            ->assertSessionHasErrors('email');
    }
}
