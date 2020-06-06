<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Database\Eloquent\Builder;
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
        $orders = Order::whereHas('customer', function (Builder $query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        })->latest()->paginate(10);

        return view('admin.dashboard', compact('orders'));
    }
}
