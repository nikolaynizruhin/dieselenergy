<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSpecification;
use App\Models\Category;
use App\Models\Specification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpecificationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $category = Category::with('attributes')->findOrFail($request->category_id);

        return view('admin.specifications.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecification $request): RedirectResponse
    {
        Specification::create($request->validated());

        return to_route('admin.categories.show', $request->category_id)
            ->with('status', __('specification.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specification $specification): View
    {
        return view('admin.specifications.edit', compact('specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSpecification $request, Specification $specification): RedirectResponse
    {
        $specification->update($request->validated());

        return to_route('admin.categories.show', $request->category_id)
            ->with('status', __('specification.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specification $specification): RedirectResponse
    {
        $specification->delete();

        return back()->with('status', __('specification.deleted'));
    }
}
