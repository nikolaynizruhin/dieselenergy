<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\ImageFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreImage;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ImageFilters $filters): View
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
     */
    public function create(): View
    {
        return view('admin.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImage $request): RedirectResponse
    {
        Image::insert($request->getImages());

        return to_route('admin.images.index')
            ->with('status', __('image.created'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image): RedirectResponse
    {
        $image->delete();

        return back()->with('status', __('image.deleted'));
    }
}
