<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('doctors')->paginate(5);

        return view('assistant.departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        $department->load('doctors');

        return view('assistant.departments.show', compact('department'));
    }
}
