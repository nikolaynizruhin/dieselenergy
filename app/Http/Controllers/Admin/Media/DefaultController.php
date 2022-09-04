<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    /**
     * Mark media as default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        $media->markAsDefault();

        return to_route('admin.products.show', $media->product_id)
            ->with('status', __('media.updated'));
    }
}
