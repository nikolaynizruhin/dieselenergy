<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\StoreOrder;
use App\Models\Customer;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('spam.block')->only('store');
    }

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

        OrderCreated::dispatch($order);

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
