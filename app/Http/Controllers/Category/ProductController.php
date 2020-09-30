<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        $products = $category
            ->products()
            ->active()
            ->withFeatured($category)
            ->filter($request->query('filter'))
            ->search('name', $request->query('search'))
            ->orderBy('name', $request->query('sort', 'asc'))
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
