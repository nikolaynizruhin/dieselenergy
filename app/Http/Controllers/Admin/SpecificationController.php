<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSpecification;
use App\Models\Category;
use App\Models\Specification;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category = Category::with('attributes')->findOrFail($request->category_id);

        return view('admin.specifications.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreSpecification  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpecification $request)
    {
        Specification::create($request->validated());

        return redirect()
            ->route('admin.categories.show', $request->category_id)
            ->with('status', __('specification.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function edit(Specification $specification)
    {
        return view('admin.specifications.edit', compact('specification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreSpecification  $request
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSpecification $request, Specification $specification)
    {
        $specification->update($request->validated());

        return redirect()
            ->route('admin.categories.show', $request->category_id)
            ->with('status', __('specification.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specification $specification)
    {
        $specification->delete();

        return back()->with('status', __('specification.deleted'));
    }
}
