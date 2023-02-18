<?php

namespace App\Actions;

use App\Events\OrderCreated;
use App\Models\Customer;
use App\Models\Order;

class CreateOrder
{
    /**
     * Create order.
     */
    public function handle(array $params): Order
    {
        $customer = Customer::updateOrCreate(
            ['email' => $params['email']],
            ['name' => $params['name'], 'phone' => $params['phone']],
        );

        $order = $customer->createOrder($params['notes']);

        OrderCreated::dispatch($order);

        return $order;
    }
}
