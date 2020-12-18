<?php

namespace App\Listeners\Order;

use App\Events\OrderCreated;

class SendConfirmedNotification
{
    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $event->order->customer->sendOrderConfirmationNotification($event->order);
    }
}
