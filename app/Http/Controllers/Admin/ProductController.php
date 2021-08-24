<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\ImageFilters;
use App\Filters\Admin\ProductFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProduct;
use App\Http\Requests\Admin\UpdateProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\Admin\ProductFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(ProductFilters $filters)
    {
        $products = Product::select('products.*')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('currencies', 'currencies.id', '=', 'brands.currency_id')
            ->with(['category', 'brand.currency'])
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category = Category::with('attributes')->findOrFail($request->category_id);

        return view('admin.products.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreProduct  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        $product = Product::create($request->getProductAttributes());

        $product->attributes()->attach($request->getAttributeValues());

        $product->images()->createMany($request->getImages());

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('product.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @param  \App\Filters\Admin\ImageFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, ImageFilters $filters)
    {
        return view('admin.products.show', [
            'product' => $product->loadAttributes(),
            'images' => $product->images()->filter($filters)->latest()->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->category->loadAttributes($product);

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateProduct  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, Product $product)
    {
        $product->update($request->getProductAttributes());

        $product->attributes()->sync($request->getAttributeValues());

        $product->images()->createMany($request->getImages());

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('product.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('status', __('product.deleted'));
    }
}
