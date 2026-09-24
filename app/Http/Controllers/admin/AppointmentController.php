<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorWorkingHour;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $appointmentDate = $request->date('appointment_date')?->format('Y-m-d');

    $patientSearch = trim($request->input('patient_search', ''));

    $doctorId = $request->input('doctor_id');

    $appointmentId = trim($request->input('appointment_id', ''));

    $appointments = Appointment::with(['patient', 'doctor'])
        ->when($appointmentDate, function ($query) use ($appointmentDate) {
            $query->whereDate('appointment_date', $appointmentDate);
        })

        ->when($patientSearch !== '', function ($query) use ($patientSearch) {

            $query->whereHas('patient', function ($query) use ($patientSearch) {

                $query->where('name', 'like', "%{$patientSearch}%")
                    ->orWhere('id', $patientSearch);

            });

        })

        ->when($doctorId, function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })

        ->when($appointmentId !== '', function ($query) use ($appointmentId) {
            $query->where('id', $appointmentId);
        })

        ->latest()
        ->paginate(5)
        ->withQueryString();

    $doctors = Doctor::orderBy('name')->get();

    return view('admin.appointments.index', compact(
        'appointments',
        'appointmentDate',
        'patientSearch',
        'doctorId',
        'appointmentId',
        'doctors'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = User::where('role', 'patient')->get();
        $doctors = Doctor::with('department')->get();

        return view('admin.appointments.create', compact(
            'patients',
            'doctors'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {

                    $appointmentDate = Carbon::parse($request->appointment_date);

                    $workingHour = DoctorWorkingHour::where('doctor_id', $request->doctor_id)
                        ->where('day_of_week', $appointmentDate->dayOfWeek)
                        ->first();

                    if (! $workingHour) {
                        $fail('The doctor is not working on the selected day.');

                        return;
                    }

                    $start = Carbon::parse($workingHour->start_time);
                    $end = Carbon::parse($workingHour->end_time);
                    $time = Carbon::parse($value);

                    if ($time->lt($start) || $time->gte($end)) {
                        $fail('The selected time is outside the doctor\'s working hours.');

                        return;
                    }

                    if ($time->minute % 15 !== 0) {
                        $fail('Appointments must be scheduled in 15-minute intervals.');
                    }
                },
            ],
            'reason' => 'nullable|string|max:255',
        ]);

        $appointmentExists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->whereTime('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($appointmentExists) {
            return back()
                ->withErrors([
                    'appointment_time' => 'This time slot is already booked.',
                ])
                ->withInput();
        }

        $validated['status'] = 'pending';

        Appointment::create($validated);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.department']);

        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = User::where('role', 'patient')->get();
        $doctors = Doctor::with('department')->get();

        return view('admin.appointments.edit', compact(
            'appointment',
            'patients',
            'doctors'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $appointmentDate = Carbon::parse($request->appointment_date);

                    $workingHour = DoctorWorkingHour::where('doctor_id', $request->doctor_id)
                        ->where('day_of_week', $appointmentDate->dayOfWeek)
                        ->first();

                    if (! $workingHour) {
                        $fail('The doctor is not working on the selected day.');

                        return;
                    }

                    $start = Carbon::parse($workingHour->start_time);
                    $end = Carbon::parse($workingHour->end_time);
                    $time = Carbon::parse($value);

                    if ($time->lt($start) || $time->gte($end)) {
                        $fail('The selected time is outside the doctor\'s working hours.');

                        return;
                    }

                    if ($time->minute % 15 !== 0) {
                        $fail('Appointments must be scheduled in 15-minute intervals.');
                    }
                },
            ],
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'reason' => 'nullable|string|max:255',
        ]);

        $appointmentExists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->whereTime('appointment_time', $validated['appointment_time'])
            ->where('id', '!=', $appointment->id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($appointmentExists) {
            return back()
                ->withErrors([
                    'appointment_time' => 'This time slot is already booked.',
                ])
                ->withInput();
        }

        $appointment->update($validated);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index');
    }
}
