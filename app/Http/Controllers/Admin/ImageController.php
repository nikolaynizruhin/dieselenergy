<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\ImageFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreImage;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ImageFilters $filters)
    {
        $images = Image::query()
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImage $request)
    {
        Image::insert($request->getImages());

        return to_route('admin.images.index')
            ->with('status', __('image.created'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();

        return back()->with('status', __('image.deleted'));
    }
}
