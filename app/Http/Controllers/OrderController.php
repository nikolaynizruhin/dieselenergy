<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\OrderCreated;
use Facades\App\Cart\Cart;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrder  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            $request->getCustomerAttributes(),
        );

        $order = $customer->createOrder($request->notes);

        Cart::store($order);

        Cart::clear();

        $customer->sendOrderConfirmationNotification($order);

        Notification::route('mail', config('company.email'))
            ->notify(new OrderCreated($order));

        return redirect()->route('orders.show', [$order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}
