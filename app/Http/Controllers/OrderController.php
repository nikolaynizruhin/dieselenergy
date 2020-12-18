<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Models\Customer;
use App\Models\Order;
use App\Events\OrderCreated;

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

        event(new OrderCreated($order));

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
