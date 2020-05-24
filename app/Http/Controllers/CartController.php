<?php

namespace App\Http\Controllers;

use App\Cart;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDate = $request->validate([
            'order_id' => 'required|numeric|exists:orders,id',
            'quantity' => 'required|numeric|min:1',
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                Rule::unique('order_product')->where(fn ($query) => $query->where([
                    'order_id' => $request->order_id,
                ])),
            ],
        ]);

        Cart::create($validatedDate);

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $validatedDate = $request->validate([
            'order_id' => 'required|numeric|exists:orders,id',
            'quantity' => 'required|numeric|min:1',
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                Rule::unique('order_product')->ignore($cart)->where(fn ($query) => $query->where([
                    'order_id' => $request->order_id,
                ])),
            ],
        ]);

        $cart->update($validatedDate);

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
