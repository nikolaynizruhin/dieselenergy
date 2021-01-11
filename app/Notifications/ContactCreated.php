<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * A contact.
     *
     * @var \App\Models\Contact
     */
    public $contact;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Новий запит на зв\'зок')
            ->line('Ви отримали новий запит на зв\'язок!')
            ->line('Ім\'я: '.$this->contact->customer->name)
            ->line('Пошта: '.$this->contact->customer->email)
            ->line('Телефон: '.$this->contact->customer->phone)
            ->line('Повідомлення: '.$this->contact->message)
            ->action('Подивитись запит', route('admin.contacts.show', $this->contact));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
