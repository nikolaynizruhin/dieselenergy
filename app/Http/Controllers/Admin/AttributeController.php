<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\AttributeFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttribute;
use App\Models\Attribute;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AttributeFilters $filters): View
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
     */
    public function create(): View
    {
        return view('admin.attributes.create', ['attribute' => new Attribute]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttribute $request): RedirectResponse
    {
        Attribute::create($request->validated());

        return to_route('admin.attributes.index')
            ->with('status', __('attribute.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute): View
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAttribute $request, Attribute $attribute): RedirectResponse
    {
        $attribute->update($request->validated());

        return to_route('admin.attributes.index')
            ->with('status', __('attribute.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute): RedirectResponse
    {
        $attribute->delete();

        return back()->with('status', __('attribute.deleted'));
    }
}
