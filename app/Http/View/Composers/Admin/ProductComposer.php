<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Brand;
use Illuminate\View\View;

class ProductComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['brands' => Brand::orderBy('name')->get()]);
    }
}
