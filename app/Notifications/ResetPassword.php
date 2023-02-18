<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.reset_password.subject'))
            ->line(__('emails.reset_password.line_1'))
            ->action(__('emails.reset_password.action'), $url)
            ->line(__('emails.reset_password.line_2', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(__('emails.reset_password.line_3'));
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     */
    protected function resetUrl($notifiable): string
    {
        return url(route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
