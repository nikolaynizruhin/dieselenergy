<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\BrandFilters;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Filters\Admin\BrandFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BrandFilters $filters)
    {
        $brands = Brand::with('currency')->filter($filters)->orderBy('name')->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
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
            'name' => 'required|string|max:255|unique:brands',
            'currency_id' => 'required|numeric|exists:currencies,id',
        ]);

        Brand::create($validated);

        return redirect()
            ->route('admin.brands.index')
            ->with('status', trans('brand.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands')->ignore($brand),
            ],
            'currency_id' => 'required|numeric|exists:currencies,id',
        ]);

        $brand->update($validated);

        return redirect()
            ->route('admin.brands.index')
            ->with('status', trans('brand.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return back()->with('status', trans('brand.deleted'));
    }
}
