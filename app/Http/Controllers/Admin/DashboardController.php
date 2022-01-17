<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\OrderFilters;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \App\Filters\Admin\OrderFilters  $filters
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(OrderFilters $filters)
    {
        $totalCustomers = Customer::count();
        $soldProducts = DB::table('order_product')->sum('quantity');
        $orders = Order::with('customer')
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', compact('orders', 'totalCustomers', 'soldProducts'));
    }
}
