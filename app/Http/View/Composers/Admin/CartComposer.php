<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Product;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with(['products' => Product::orderBy('name')->get()]);
    }
}
