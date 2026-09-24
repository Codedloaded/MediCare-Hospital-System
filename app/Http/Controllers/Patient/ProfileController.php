<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $patient = auth()->user();

        return view('patients.profile.index', compact('patient'));
    }

    public function edit()
    {
        $patient = auth()->user();

        return view('patients.profile.edit', compact('patient'));
    }

    public function update(Request $request)
    {
        $patient = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($patient->id),
            ],

            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Name & Email
        |--------------------------------------------------------------------------
        */

        $patient->name = $validated['name'];
        $patient->email = $validated['email'];

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['password'])) {

            if (
                empty($validated['current_password']) ||
                ! Hash::check($validated['current_password'], $patient->password)
            ) {
                return back()
                    ->withErrors([
                        'current_password' => 'The current password is incorrect.',
                    ])
                    ->withInput();
            }

            $patient->password = Hash::make($validated['password']);
        }

        $patient->save();

        return redirect()
            ->route('patient.profile')
            ->with('success', 'Profile updated successfully.');
    }
}
