<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedia;
use App\Media;
use App\Product;
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
            ->with('status', 'Image was attached successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return back()->with('status', 'Image was detached successfully!');
    }
}
