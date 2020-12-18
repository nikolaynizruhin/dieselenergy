<?php

namespace App\Listeners\Order;

use App\Events\OrderCreated;
use App\Notifications\OrderCreated as OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        Notification::route('mail', config('company.email'))
            ->notify(new OrderCreatedNotification($event->order));
    }
}
