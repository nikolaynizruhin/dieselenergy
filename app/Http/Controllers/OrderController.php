<?php

namespace App\Http\Controllers;

use App\Cart as CartModel;
use App\Http\Requests\StoreOrder;
use Facades\App\Cart\Cart;
use App\Customer;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            ['name' => $request->name, 'phone' => $request->phone],
        );

        $order = $customer->orders()->create([
            'status' => Order::NEW,
            'total' => Cart::total(),
            'notes' => $request->notes,
        ]);

        Cart::items()->each(fn ($item) => CartModel::create([
            'product_id' => $item->id,
            'order_id' => $order->id,
            'quantity' => $item->quantity,
        ]));

        Cart::clear();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
