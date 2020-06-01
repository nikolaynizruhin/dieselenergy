<?php

namespace App\Http\View\Composers;

use App\Image;
use Illuminate\View\View;

class MediaComposer
{
    /**
     * Bind data to the view.
     *
     * @param  Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['images' => Image::all()]);
    }
}
