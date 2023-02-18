<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\Customer\ContactFilters;
use App\Filters\Admin\Customer\OrderFilters;
use App\Filters\Admin\CustomerFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCustomer;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomerFilters $filters): View
    {
        $customers = Customer::query()
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.customers.create', ['customer' => new Customer]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomer $request): RedirectResponse
    {
        Customer::create($request->validated());

        return to_route('admin.customers.index')
            ->with('status', __('customer.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, ContactFilters $contactFilters, OrderFilters $orderFilters): View
    {
        $contacts = $customer
            ->contacts()
            ->filter($contactFilters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $orders = $customer
            ->orders()
            ->filter($orderFilters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.show', compact('customer', 'contacts', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCustomer $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());

        return to_route('admin.customers.index')
            ->with('status', __('customer.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return back()->with('status', __('customer.deleted'));
    }
}
