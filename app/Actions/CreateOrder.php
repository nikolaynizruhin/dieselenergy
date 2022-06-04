<?php

namespace App\Actions;

use App\Events\OrderCreated;
use App\Models\Customer;
use App\Models\Order;

class CreateOrder
{
    /**
     * Create order.
     *
     * @param  array  $params
     * @return Order
     */
    public function handle(array $params)
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
