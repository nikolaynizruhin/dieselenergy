<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'totalCustomers' => Customer::count(),
            'soldProducts' => DB::table('order_product')->sum('quantity'),
        ]);
    }
}
