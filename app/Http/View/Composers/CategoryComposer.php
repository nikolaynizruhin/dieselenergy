<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['categories' => Category::all()]);
    }
}
