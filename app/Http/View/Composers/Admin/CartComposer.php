<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Product;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @param  Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['products' => Product::orderBy('name')->get()]);
    }
}
