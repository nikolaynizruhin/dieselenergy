<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContact;
use Facades\App\Actions\CreateContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [new Middleware('spam.block')];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContact $request): RedirectResponse
    {
        CreateContact::handle($request->getContactAttributes());

        return redirect()
            ->back()
            ->withFragment('contact')
            ->with('status', __('contact.created'));
    }
}
