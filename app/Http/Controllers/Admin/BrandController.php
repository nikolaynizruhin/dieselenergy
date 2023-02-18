<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\BrandFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrand;
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BrandFilters $filters)
    {
        $brands = Brand::select('brands.*')
            ->join('currencies', 'currencies.id', '=', 'brands.currency_id')
            ->with('currency')
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create', ['brand' => new Brand]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrand $request)
    {
        Brand::create($request->validated());

        return to_route('admin.brands.index')
            ->with('status', __('brand.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBrand $request, Brand $brand)
    {
        $brand->update($request->validated());

        return to_route('admin.brands.index')
            ->with('status', __('brand.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return back()->with('status', __('brand.deleted'));
    }
}
