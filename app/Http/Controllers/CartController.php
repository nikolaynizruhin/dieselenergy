<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCart;
use Facades\App\Services\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $items = Cart::items();
        $total = Cart::total();

        return view('carts.index', compact('items', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCart $request): RedirectResponse
    {
        Cart::add($request->product, $request->quantity);

        return to_route('carts.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate(['quantity' => 'required|numeric|min:1']);

        Cart::update($id, $request->quantity);

        return to_route('carts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        Cart::delete($id);

        return back();
    }
}
