<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\AttributeFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttribute;
use App\Http\Requests\Admin\UpdateAttribute;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\Admin\AttributeFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(AttributeFilters $filters)
    {
        $attributes = Attribute::filter($filters)->orderBy('name')->paginate(10);

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreAttribute  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttribute $request)
    {
        Attribute::create($request->validated());

        return redirect()
            ->route('admin.attributes.index')
            ->with('status', __('attribute.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateAttribute  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttribute $request, Attribute $attribute)
    {
        $attribute->update($request->validated());

        return redirect()
            ->route('admin.attributes.index')
            ->with('status', __('attribute.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return back()->with('status', __('attribute.deleted'));
    }
}
