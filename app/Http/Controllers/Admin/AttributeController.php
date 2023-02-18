<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\AttributeFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttribute;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttributeFilters $filters)
    {
        $attributes = Attribute::query()
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.create', ['attribute' => new Attribute]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttribute $request)
    {
        Attribute::create($request->validated());

        return to_route('admin.attributes.index')
            ->with('status', __('attribute.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAttribute $request, Attribute $attribute)
    {
        $attribute->update($request->validated());

        return to_route('admin.attributes.index')
            ->with('status', __('attribute.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return back()->with('status', __('attribute.deleted'));
    }
}
