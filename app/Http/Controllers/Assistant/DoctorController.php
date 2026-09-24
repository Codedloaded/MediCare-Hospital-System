<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $departmentId = $request->integer('department_id') ?: null;

        $doctors = Doctor::with('department')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->paginate(5)
            ->withQueryString();

        $departments = Department::orderBy('name')->get();

        return view('assistant.doctors.index', compact(
            'doctors',
            'departments',
            'search',
            'departmentId'
        ));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('department');

        return view('assistant.doctors.show', compact('doctor'));
    }
}
