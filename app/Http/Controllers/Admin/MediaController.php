<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedia;
use App\Http\Requests\Admin\UpdateMedia;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = Product::with('images')->findOrFail($request->product_id);

        return view('admin.medias.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreMedia  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedia $request)
    {
        Media::create($request->validated());

        return redirect()
            ->route('admin.products.show', $request->product_id)
            ->with('status', trans('media.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        return view('admin.medias.edit', compact('media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateMedia  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedia $request, Media $media)
    {
        $media->update($request->validated());

        return redirect()
            ->route('admin.products.show', $request->product_id)
            ->with('status', trans('media.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return back()->with('status', trans('media.deleted'));
    }
}
