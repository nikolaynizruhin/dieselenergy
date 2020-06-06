<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSpecification;
use App\Specification;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category = Category::with('attributes')->findOrFail($request->category_id);

        return view('admin.specifications.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreSpecification  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpecification $request)
    {
        Specification::create([
            'attribute_id' => $request->attribute_id,
            'attributable_type' => Category::class,
            'attributable_id' => $request->category_id,
        ]);

        return redirect()
            ->route('admin.categories.show', $request->category_id)
            ->with('status', 'Attribute was attached successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specification $specification)
    {
        $specification->delete();

        return back()->with('status', 'Attribute was detached successfully!');
    }
}
