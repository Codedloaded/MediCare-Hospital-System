<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = auth()->user();

        $upcomingAppointment = Appointment::with(['doctor.department'])
            ->where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) {
                $query->whereDate('appointment_date', '>', today())
                    ->orWhere(function ($query) {
                        $query->whereDate('appointment_date', today())
                            ->whereTime('appointment_time', '>=', now()->format('H:i:s'));
                    });
            })
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->first();

        $appointmentCount = Appointment::where('patient_id', $patient->id)->count();

        $departments = Department::withCount('doctors')
            ->latest()
            ->take(3)
            ->get();

        $doctors = Doctor::with('department')
            ->latest()
            ->take(4)
            ->get();

        return view('patients.dashboard', compact(
            'upcomingAppointment',
            'appointmentCount',
            'departments',
            'doctors'
        ));
    }
}
