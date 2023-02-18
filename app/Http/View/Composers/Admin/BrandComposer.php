<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Currency;
use Illuminate\View\View;

class BrandComposer
{
    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['currencies' => Currency::orderBy('code')->get()]);
    }
}
