<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Customer;
use Illuminate\View\View;

class ContactComposer
{
    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['customers' => Customer::orderBy('name')->get()]);
    }
}
