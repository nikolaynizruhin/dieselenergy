<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate(['password' => 'required|string|min:8|confirmed']);

        $user->update(['password' => $request->password]);

        return to_route('admin.users.index')
            ->with('status', __('user.password.updated'));
    }
}
