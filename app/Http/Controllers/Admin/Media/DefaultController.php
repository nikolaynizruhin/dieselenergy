<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    /**
     * Mark media as default.
     */
    public function update(Request $request, Media $media): RedirectResponse
    {
        $media->markAsDefault();

        return to_route('admin.products.show', $media->product_id)
            ->with('status', __('media.updated'));
    }
}
