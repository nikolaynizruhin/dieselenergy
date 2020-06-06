<?php

namespace App\Http\View\Composers\Admin;

use App\Customer;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardComposer
{
    /**
     * Bind data to the view.
     *
     * @param  Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'totalOrders' => Order::count(),
            'totalCustomers' => Customer::count(),
            'soldProducts' => DB::table('order_product')->sum('quantity'),
        ]);
    }
}
