<?php

namespace App\Http\Controllers;

use App\Media;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = Product::with('images')->findOrFail($request->product_id);

        return view('medias.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDate = $request->validate([
            'image_id' => 'required|numeric|exists:images,id',
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                Rule::unique('image_product')->where(fn ($query) => $query->where([
                    'image_id' => $request->image_id,
                ])),
            ],
        ]);

        Media::create($validatedDate);

        return redirect()
            ->route('products.show', $request->product_id)
            ->with('status', 'Image was attached successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
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
