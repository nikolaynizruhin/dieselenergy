<?php

namespace App\Http\View\Composers;

use App\Brand;
use Illuminate\View\View;

class ProductComposer
{
    /**
     * Bind data to the view.
     *
     * @param  Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['brands' => Brand::all()]);
    }
}
