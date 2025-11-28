<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Show the user's profile editing form.
     */
    public function show()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'], // Validation for the 'phone' input field from your form
            'address' => ['nullable', 'string', 'max:500'], // Validation for the 'address' input field from your form
        ]);

        // --- START OF THE CRITICAL CHANGES ---
        // 1. Fill the user model with attributes that directly match database columns AND are fillable.
        //    'phone' is explicitly *excluded* from 'only()' because its database column is 'phone_no'.
        $user->fill($request->only('name', 'email', 'address'));

        // 2. Manually assign the 'phone' request input to the 'phone_no' database column.
        //    This maps the form input name 'phone' to the DB column 'phone_no'.
        $user->phone_no = $request->phone;
        // --- END OF THE CRITICAL CHANGES ---


        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('user.profile.show')->with('success', 'Profile updated successfully!');
    }
}