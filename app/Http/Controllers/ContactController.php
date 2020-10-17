<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContact;
use App\Models\Customer;
use App\Notifications\ContactCreated;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContact  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContact $request)
    {
        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            $request->getCustomerAttributes(),
        );

        $contact = $customer->createContact($request->message);

        Notification::route('mail', config('mail.to.address'))
            ->notify(new ContactCreated($contact));

        return redirect(route('home').'#contact')->with('status', trans('contact.created'));
    }
}
