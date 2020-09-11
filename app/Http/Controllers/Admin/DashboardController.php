<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {
        $orders = Order::with('customer')
            ->searchByCustomer('name', $request->search)
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('orders'));
    }
}
