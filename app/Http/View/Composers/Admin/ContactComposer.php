<?php

namespace App\Http\View\Composers\Admin;

use App\Customer;
use Illuminate\View\View;

class ContactComposer
{
    /**
     * Bind data to the view.
     *
     * @param  Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['customers' => Customer::orderBy('name')->get()]);
    }
}
