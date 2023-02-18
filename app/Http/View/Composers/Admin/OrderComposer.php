<?php

namespace App\Http\View\Composers\Admin;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\View\View;

class OrderComposer
{
    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'customers' => Customer::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
            'statuses' => OrderStatus::all(),
        ]);
    }
}
