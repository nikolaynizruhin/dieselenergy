<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\AttributeFilters;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\Admin\AttributeFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AttributeFilters $filters)
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:attributes',
            'measure' => 'nullable|string|max:255',
        ]);

        Attribute::create($validated);

        return redirect()
            ->route('admin.attributes.index')
            ->with('status', trans('attribute.created'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('attributes')->ignore($attribute),
            ],
            'measure' => 'nullable|string|max:255',
        ]);

        $attribute->update($validated);

        return redirect()
            ->route('admin.attributes.index')
            ->with('status', trans('attribute.updated'));
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

        return back()->with('status', trans('attribute.deleted'));
    }
}
