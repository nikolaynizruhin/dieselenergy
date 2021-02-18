<?php

namespace App\Http\Controllers\Category;

use App\Filters\ProductFilters;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @param \App\Filters\ProductFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category, ProductFilters $filters)
    {
        $products = $category
            ->products()
            ->active()
            ->with(['category', 'brand.currency'])
            ->withFeaturedAttributes($category)
            ->withDefaultImage()
            ->filter($filters)
            ->orderBy('name')
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
        return view('products.show', [
            'product' => $product->loadAttributes(),
            'recommendations' => $product->recommendations(),
        ]);
    }
}
