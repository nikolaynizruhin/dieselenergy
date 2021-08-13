<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\CurrencyFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCurrency;
use App\Http\Requests\Admin\UpdateCurrency;
use App\Models\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\Admin\CurrencyFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyFilters $filters)
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
     * @param  \App\Http\Requests\Admin\StoreCurrency  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurrency $request)
    {
        Currency::create($request->validated());

        return redirect()
            ->route('admin.currencies.index')
            ->with('status', __('currency.created'));
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
     * @param  \App\Http\Requests\Admin\UpdateCurrency  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurrency $request, Currency $currency)
    {
        $currency->update($request->validated());

        return redirect()
            ->route('admin.currencies.index')
            ->with('status', __('currency.updated'));
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

        return back()->with('status', __('currency.deleted'));
    }
}
