<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
{
    $departmentCount = Department::count();

    $doctorCount = Doctor::count();

    $patientCount = User::where('role', 'patient')->count();

    $appointmentCount = Appointment::count();

    $todayAppointmentCount = Appointment::whereDate(
        'appointment_date',
        today()
    )->count();

    $pendingAppointmentCount = Appointment::where(
        'status',
        'pending'
    )->count();

    $medicalAssistantCount = User::where(
        'role',
        'medical_assistant'
    )->count();

    $todayAppointments = Appointment::with([
        'patient',
        'doctor.department'
    ])
    ->whereDate('appointment_date', today())
    ->orderBy('appointment_time')
    ->get();

    return view('admin.dashboard', compact(
        'departmentCount',
        'doctorCount',
        'patientCount',
        'appointmentCount',
        'todayAppointmentCount',
        'pendingAppointmentCount',
        'medicalAssistantCount',
        'todayAppointments'
    ));
}
}
