<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCart;
use Facades\App\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Cart::items();

        return view('carts.index', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCart  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCart $request)
    {
        Cart::add($request->product, $request->quantity);

        return back()->with('status', trans('cart.added'));
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
        $request->validate(['quantity' => 'required|numeric|min:1']);

        Cart::update($id, $request->quantity);

        return redirect()
            ->route('carts.index')
            ->with('status', trans('carts.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::delete($id);

        return back()->with('status', trans('cart.deleted'));
    }
}
