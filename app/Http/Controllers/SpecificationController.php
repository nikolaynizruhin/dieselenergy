<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreSpecification;
use App\Specification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        return view('specifications.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSpecification  $request
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
            ->route('categories.show', $request->category_id)
            ->with('status', 'Attribute was attached successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
