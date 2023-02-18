<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate(['password' => 'required|string|min:8|confirmed']);

        $user->update(['password' => Hash::make($request->password)]);

        return to_route('admin.users.index')
            ->with('status', __('user.password.updated'));
    }
}
