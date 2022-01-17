<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCart;
use Facades\App\Services\Cart;
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
        $total = Cart::total();

        return view('carts.index', compact('items', 'total'));
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

        return redirect()->route('carts.index');
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

        return redirect()->route('carts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::delete($id);

        return back();
    }
}
