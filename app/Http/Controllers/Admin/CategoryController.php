<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\AttributeFilters;
use App\Filters\Admin\CategoryFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategory;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryFilters $filters): View
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
     */
    public function create(): View
    {
        return view('admin.categories.create', ['category' => new Category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategory $request): RedirectResponse
    {
        Category::create($request->validated());

        return to_route('admin.categories.index')
            ->with('status', __('category.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, AttributeFilters $filters): View
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
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategory $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return to_route('admin.categories.index')
            ->with('status', __('category.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('status', __('category.deleted'));
    }
}
