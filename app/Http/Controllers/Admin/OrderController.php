<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\OrderFilters;
use App\Filters\Admin\ProductFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrder;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderFilters $filters)
    {
        $orders = Order::select('orders.*')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->with('customer')
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orders.create', ['order' => new Order]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        Order::create($request->validated());

        return to_route('admin.orders.index')
            ->with('status', __('order.created'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, ProductFilters $filters)
    {
        $products = $order->products()
            ->select('products.*', DB::raw('price * quantity total'))
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.show', compact('order', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrder $request, Order $order)
    {
        $order->update($request->prepared());

        return to_route('admin.orders.index')
            ->with('status', __('order.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('status', __('order.deleted'));
    }
}
