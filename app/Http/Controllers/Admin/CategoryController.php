<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\AttributeFilters;
use App\Filters\Admin\CategoryFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategory;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryFilters $filters)
    {
        $categories = Category::query()
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create', ['category' => new Category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        Category::create($request->validated());

        return to_route('admin.categories.index')
            ->with('status', __('category.created'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, AttributeFilters $filters)
    {
        $attributes = $category
            ->attributes()
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.show', compact('category', 'attributes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, Category $category)
    {
        $category->update($request->validated());

        return to_route('admin.categories.index')
            ->with('status', __('category.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('status', __('category.deleted'));
    }
}
