<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\ContactFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContact;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\Admin\ContactFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(ContactFilters $filters)
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contacts.create', ['contact' => new Contact]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreContact  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContact $request)
    {
        Contact::create($request->validated());

        return redirect()
            ->route('admin.contacts.index')
            ->with('status', __('contact.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreContact  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContact $request, Contact $contact)
    {
        $contact->update($request->validated());

        return redirect()
            ->route('admin.contacts.index')
            ->with('status', __('contact.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('status', __('contact.deleted'));
    }
}
