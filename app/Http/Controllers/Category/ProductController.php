<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterProducts;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\FilterProducts  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(FilterProducts $request, Category $category)
    {
        $products = $category
            ->products()
            ->active()
            ->withFeatured($category)
            ->filter($request->filter)
            ->search('name', $request->search)
            ->orderBy($request->column(), $request->direction())
            ->paginate(9);

        return view('categories.products.index', compact('products', 'category'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load(['attributes' => fn ($query) => $query->whereNotNull('value')]);

        return view('products.show', compact('product'));
    }
}
