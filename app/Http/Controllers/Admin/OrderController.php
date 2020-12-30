<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\OrderFilters;
use App\Filters\Admin\ProductFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrder;
use App\Http\Requests\Admin\UpdateOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Filters\Admin\OrderFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OrderFilters $filters)
    {
        $orders = Order::select('orders.*')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->filter($filters)
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreOrder  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        Order::create($request->validated());

        return redirect()
            ->route('admin.orders.index')
            ->with('status', trans('order.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Filters\Admin\ProductFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, Request $request, ProductFilters $filters)
    {
        $products = $order->products()
            ->select('products.*', DB::raw('price * quantity total'))
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10);

        return view('admin.orders.show', compact('order', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateOrder  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrder $request, Order $order)
    {
        $order->update($request->prepared());

        return redirect()
            ->route('admin.orders.index')
            ->with('status', trans('order.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('status', trans('order.deleted'));
    }
}
