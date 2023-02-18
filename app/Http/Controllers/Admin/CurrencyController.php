<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\CurrencyFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCurrency;
use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CurrencyFilters $filters): View
    {
        $currencies = Currency::query()
            ->filter($filters)
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('admin.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.currencies.create', ['currency' => new Currency]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrency $request): RedirectResponse
    {
        Currency::create($request->validated());

        return to_route('admin.currencies.index')
            ->with('status', __('currency.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency): View
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCurrency $request, Currency $currency): RedirectResponse
    {
        $currency->update($request->validated());

        return to_route('admin.currencies.index')
            ->with('status', __('currency.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency): RedirectResponse
    {
        $currency->delete();

        return back()->with('status', __('currency.deleted'));
    }
}
