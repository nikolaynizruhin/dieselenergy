<?php

namespace App\Http\View\Composers\Admin;

use App\Models\Attribute;
use Illuminate\View\View;

class SpecificationComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with(['attributes' => Attribute::orderBy('name')->get()]);
    }
}
