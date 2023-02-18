<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\BrandFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrand;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BrandFilters $filters): View
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
     */
    public function create(): View
    {
        return view('admin.brands.create', ['brand' => new Brand]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrand $request): RedirectResponse
    {
        Brand::create($request->validated());

        return to_route('admin.brands.index')
            ->with('status', __('brand.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBrand $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return to_route('admin.brands.index')
            ->with('status', __('brand.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return back()->with('status', __('brand.deleted'));
    }
}
