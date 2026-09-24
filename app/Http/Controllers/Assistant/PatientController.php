<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();

        $patients = User::where('role', 'patient')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->when(ctype_digit($search), function ($query) use ($search) {
                            $query->orWhere('id', $search);
                        });
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('assistant.patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('assistant.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'patient';

        User::create($validated);

        return redirect()->route('assistant.patients.index');
    }
}
