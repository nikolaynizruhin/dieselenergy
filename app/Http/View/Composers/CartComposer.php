<?php

namespace App\Http\View\Composers;

use Facades\App\Cart\Cart;
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
        $view->with(['total' => Cart::total()]);
    }
}
