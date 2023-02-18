<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Models\Order;
use Facades\App\Actions\CreateOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
     */
    public function store(StoreOrder $request): RedirectResponse
    {
        $order = CreateOrder::handle($request->getOrderAttributes());

        return to_route('orders.show', [$order]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        return view('orders.show', compact('order'));
    }
}
