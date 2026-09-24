<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('doctors')->get();

        return view('patients.departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        $department->load('doctors');

        return view('patients.departments.show', compact('department'));
    }
}
