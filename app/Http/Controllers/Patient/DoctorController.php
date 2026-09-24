<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('department')->get();

        return view('patients.doctors.index', compact('doctors'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('department');

        return view('patients.doctors.show', compact('doctor'));
    }
}
