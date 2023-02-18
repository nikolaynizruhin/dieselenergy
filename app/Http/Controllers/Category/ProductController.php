<?php

namespace App\Http\Controllers\Category;

use App\Filters\ProductFilters;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category, ProductFilters $filters): View
    {
        $products = $category
            ->products()
            ->active()
            ->with(['category', 'brand.currency'])
            ->withFeaturedAttributes($category)
            ->withDefaultImage()
            ->filter($filters)
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('categories.products.index', compact('products', 'category'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('products.show', ['product' => $product->loadAttributes()]);
    }
}
