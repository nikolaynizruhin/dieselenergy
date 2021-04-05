<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\OrderFilters;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
        $orders = Order::with('customer')
            ->filter($filters)
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('orders'));
    }
}
