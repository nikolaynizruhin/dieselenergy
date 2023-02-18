<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedia;
use App\Models\Image;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $images = Image::latest()->get();
        $product = Product::with('images')->findOrFail($request->product_id);

        return view('admin.medias.create', compact('product', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedia $request): RedirectResponse
    {
        Media::create($request->validated());

        return to_route('admin.products.show', $request->product_id)
            ->with('status', __('media.created'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media): RedirectResponse
    {
        $media->delete();

        return back()->with('status', __('media.deleted'));
    }
}
