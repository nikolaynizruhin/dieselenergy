<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\Customer\ContactFilters;
use App\Filters\Admin\Customer\OrderFilters;
use App\Filters\Admin\CustomerFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCustomer;
use App\Http\Requests\Admin\UpdateCustomer;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\Admin\CustomerFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerFilters $filters)
    {
        $customers = Customer::filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreCustomer  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        Customer::create($request->validated());

        return redirect()
            ->route('admin.customers.index')
            ->with('status', __('customer.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @param  \App\Filters\Admin\Customer\ContactFilters  $contactFilters
     * @param  \App\Filters\Admin\Customer\OrderFilters  $orderFilters
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, ContactFilters $contactFilters, OrderFilters $orderFilters)
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
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateCustomer  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, Customer $customer)
    {
        $customer->update($request->validated());

        return redirect()
            ->route('admin.customers.index')
            ->with('status', __('customer.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('status', __('customer.deleted'));
    }
}
