<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCart;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $order = Order::with('customer')->findOrFail($request->order_id);

        return view('admin.carts.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCart $request): RedirectResponse
    {
        Cart::create($request->validated());

        return to_route('admin.orders.show', $request->order_id)
            ->with('status', __('cart.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart): View
    {
        return view('admin.carts.edit', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCart $request, Cart $cart): RedirectResponse
    {
        $cart->update($request->validated());

        return to_route('admin.orders.show', $request->order_id)
            ->with('status', __('cart.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart): RedirectResponse
    {
        $cart->delete();

        return back()->with('status', __('cart.deleted'));
    }
}
