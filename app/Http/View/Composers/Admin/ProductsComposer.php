<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Category;
use Illuminate\View\View;

class ProductsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['categories' => Category::orderBy('name')->get()]);
    }
}
