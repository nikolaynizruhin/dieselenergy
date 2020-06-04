<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Requests\StoreCart;
use App\Http\Requests\UpdateCart;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $order = Order::with('customer')->findOrFail($request->order_id);

        return view('carts.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCart  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCart $request)
    {
        Cart::create($request->validated());

        return redirect()
            ->route('orders.show', $request->order_id)
            ->with('status', 'Product was attached successfully!');
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
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        return view('carts.edit', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCart  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCart $request, Cart $cart)
    {
        $cart->update($request->validated());

        return redirect()
            ->route('orders.show', $request->order_id)
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
