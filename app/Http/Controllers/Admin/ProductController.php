<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\ImageFilters;
use App\Filters\Admin\ProductFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductFilters $filters): View
    {
        $categories = Category::orderBy('name')->get();
        $products = Product::select('products.*')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('currencies', 'currencies.id', '=', 'brands.currency_id')
            ->with(['category', 'brand.currency'])
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $category = Category::with('attributes')->findOrFail($request->category_id);

        return view('admin.products.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProduct $request): RedirectResponse
    {
        $product = Product::create($request->getProductAttributes());

        $product->attributes()->attach($request->getAttributeValues());

        $product->images()->createMany($request->getImages());

        return to_route('admin.products.index')
            ->with('status', __('product.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, ImageFilters $filters): View
    {
        $product = $product->loadAttributes();

        $images = $product
            ->images()
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.show', compact('product', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $product->category->loadAttributes($product);

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProduct $request, Product $product): RedirectResponse
    {
        $product->update($request->getProductAttributes());

        $product->attributes()->sync($request->getAttributeValues());

        $product->images()->createMany($request->getImages());

        return to_route('admin.products.index')
            ->with('status', __('product.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('status', __('product.deleted'));
    }
}
