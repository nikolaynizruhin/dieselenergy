<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\CurrencyFilters;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Filters\Admin\CurrencyFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CurrencyFilters $filters)
    {
        $currencies = Currency::filter($filters)->orderBy('code')->paginate(10);

        return view('admin.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies',
            'symbol' => 'required|string|unique:currencies',
            'rate' => 'required|numeric|min:0',
        ]);

        Currency::create($validated);

        return redirect()
            ->route('admin.currencies.index')
            ->with('status', trans('currency.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'rate' => 'required|numeric|min:0',
            'code' => [
                'required',
                'string',
                'size:3',
                Rule::unique('currencies')->ignore($currency),
            ],
            'symbol' => [
                'required',
                'string',
                Rule::unique('currencies')->ignore($currency),
            ],
        ]);

        $currency->update($validated);

        return redirect()
            ->route('admin.currencies.index')
            ->with('status', trans('currency.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return back()->with('status', trans('currency.deleted'));
    }
}
