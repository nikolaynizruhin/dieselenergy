<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserFilters $filters): View
    {
        $users = User::query()
            ->filter($filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser $request): RedirectResponse
    {
        User::create($request->getAttributes());

        return to_route('admin.users.index')
            ->with('status', __('user.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUser $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return to_route('admin.users.index')
            ->with('status', __('user.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('status', __('user.deleted'));
    }
}
