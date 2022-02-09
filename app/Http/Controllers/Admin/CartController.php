<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCart;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $order = Order::with('customer')->findOrFail($request->order_id);

        return view('admin.carts.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreCart  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCart $request)
    {
        Cart::create($request->validated());

        return to_route('admin.orders.show', $request->order_id)
            ->with('status', __('cart.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        return view('admin.carts.edit', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreCart  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCart $request, Cart $cart)
    {
        $cart->update($request->validated());

        return to_route('admin.orders.show', $request->order_id)
            ->with('status', __('cart.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back()->with('status', __('cart.deleted'));
    }
}
