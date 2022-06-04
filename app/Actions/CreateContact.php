<?php

namespace App\Actions;

use App\Models\Contact;
use App\Models\Customer;
use App\Notifications\ContactCreated;
use Illuminate\Support\Facades\Notification;

class CreateContact
{
    /**
     * Create contact.
     *
     * @param  array  $params
     * @return Contact
     */
    public function handle(array $params)
    {
        $customer = Customer::updateOrCreate(
            ['email' => $params['email']],
            ['name' => $params['name'], 'phone' => $params['phone']],
        );

        $contact = $customer->createContact($params['message']);

        Notification::route('mail', config('company.email'))
            ->notify(new ContactCreated($contact));

        return $contact;
    }
}
