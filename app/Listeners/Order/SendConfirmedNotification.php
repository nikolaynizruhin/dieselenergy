<?php

namespace App\Listeners\Order;

use App\Events\OrderCreated;

class SendConfirmedNotification
{
    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $event->order->customer->sendOrderConfirmationNotification($event->order);
    }
}
