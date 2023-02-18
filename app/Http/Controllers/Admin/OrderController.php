<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\OrderFilters;
use App\Filters\Admin\ProductFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrder;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderFilters $filters): View
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
     */
    public function create(): View
    {
        return view('admin.orders.create', ['order' => new Order]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrder $request): RedirectResponse
    {
        Order::create($request->validated());

        return to_route('admin.orders.index')
            ->with('status', __('order.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, ProductFilters $filters): View
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
     */
    public function edit(Order $order): View
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrder $request, Order $order): RedirectResponse
    {
        $order->update($request->prepared());

        return to_route('admin.orders.index')
            ->with('status', __('order.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return back()->with('status', __('order.deleted'));
    }
}
