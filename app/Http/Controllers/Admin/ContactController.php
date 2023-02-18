<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\ContactFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContact;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContactFilters $filters): View
    {
        $contacts = Contact::select('contacts.*')
            ->join('customers', 'customers.id', '=', 'contacts.customer_id')
            ->with('customer')
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.contacts.create', ['contact' => new Contact]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContact $request): RedirectResponse
    {
        Contact::create($request->validated());

        return to_route('admin.contacts.index')
            ->with('status', __('contact.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): View
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact): View
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreContact $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return to_route('admin.contacts.index')
            ->with('status', __('contact.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return back()->with('status', __('contact.deleted'));
    }
}
