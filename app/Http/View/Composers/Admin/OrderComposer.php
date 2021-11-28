<?php

namespace App\Http\View\Composers\Admin;

use App\Enums\Status;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\View\View;

class OrderComposer
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
            'customers' => Customer::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
            'statuses' => Status::all(),
        ]);
    }
}
