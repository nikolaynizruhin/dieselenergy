<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        return view('dashboard', compact('orders'));
    }
}
