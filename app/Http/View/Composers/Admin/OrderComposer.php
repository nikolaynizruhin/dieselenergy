<?php

namespace App\Http\View\Composers\Admin;

use App\Customer;
use App\Order;
use App\Product;
use Illuminate\View\View;

class OrderComposer
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
            'customers' => Customer::all(),
            'products' => Product::all(),
            'statuses' => Order::statuses(),
        ]);
    }
}
