<?php

namespace App\Http\View\Composers;

use App\Attribute;
use App\Category;
use Illuminate\View\View;

class SpecificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'attributes' => Attribute::all(),
            'categories' => Category::all(),
        ]);
    }
}
