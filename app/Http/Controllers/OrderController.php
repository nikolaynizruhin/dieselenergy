<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Models\Order;
use Facades\App\Actions\CreateOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class OrderController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [new Middleware('spam.block', only: ['store'])];
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
