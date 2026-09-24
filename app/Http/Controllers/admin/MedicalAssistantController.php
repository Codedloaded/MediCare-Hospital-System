<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MedicalAssistantController extends Controller
{
    public function index()
    {
        $medicalAssistants = User::where('role', 'medical_assistant')
            ->latest()
            ->paginate(10);

        return view(
            'admin.medical-assistants.index',
            compact('medicalAssistants')
        );
    }

    public function create()
    {
        return view('admin.medical-assistants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'medical_assistant',
        ]);

        return redirect()
            ->route('admin.medical-assistants.index')
            ->with('success', 'Medical assistant created successfully.');
    }

    public function edit(User $medicalAssistant)
    {
        if ($medicalAssistant->role !== 'medical_assistant') {
            abort(404);
        }

        return view(
            'admin.medical-assistants.edit',
            compact('medicalAssistant')
        );
    }

    public function update(Request $request, User $medicalAssistant)
    {
        if ($medicalAssistant->role !== 'medical_assistant') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($medicalAssistant->id),
            ],

            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $medicalAssistant->name = $validated['name'];
        $medicalAssistant->email = $validated['email'];

        if (! empty($validated['password'])) {
            $medicalAssistant->password = Hash::make(
                $validated['password']
            );
        }

        $medicalAssistant->save();

        return redirect()
            ->route('admin.medical-assistants.index')
            ->with('success', 'Medical assistant updated successfully.');
    }

    public function destroy(User $medicalAssistant)
    {
        if ($medicalAssistant->role !== 'medical_assistant') {
            abort(404);
        }

        $medicalAssistant->delete();

        return redirect()
            ->route('admin.medical-assistants.index')
            ->with('success', 'Medical assistant deleted successfully.');
    }
}
