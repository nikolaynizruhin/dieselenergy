<?php

namespace App\Http\Controllers\Admin;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCart;
use App\Http\Requests\Admin\UpdateCart;
use App\Order;
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

        return redirect()
            ->route('admin.orders.show', $request->order_id)
            ->with('status', 'Product was attached successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        return view('admin.carts.edit', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateCart  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCart $request, Cart $cart)
    {
        $cart->update($request->validated());

        return redirect()
            ->route('admin.orders.show', $request->order_id)
            ->with('status', 'Cart was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back()->with('status', 'Product was detached successfully!');
    }
}
