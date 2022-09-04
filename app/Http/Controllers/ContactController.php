<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContact;
use Facades\App\Actions\CreateContact;

class ContactController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('spam.block');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContact  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContact $request)
    {
        CreateContact::handle($request->getContactAttributes());

        return redirect()
            ->back()
            ->withFragment('contact')
            ->with('status', __('contact.created'));
    }
}
