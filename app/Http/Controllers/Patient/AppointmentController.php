<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\DoctorWorkingHour;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $patientId = auth()->id();

        $upcomingAppointments = Appointment::with(['doctor.department'])
            ->where('patient_id', $patientId)
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
            ->get();

        $appointmentHistory = Appointment::with(['doctor.department'])
            ->where('patient_id', $patientId)
            ->where(function ($query) {
                $query->whereDate('appointment_date', '<', today())
                    ->orWhereIn('status', ['completed', 'cancelled']);
            })
            ->latest('appointment_date')
            ->latest('appointment_time')
            ->get();

        return view('patients.appointments.index', compact(
            'upcomingAppointments',
            'appointmentHistory'
        ));
    }

    public function create()
    {
        $departments = Department::with('doctors')->get();

        return view('patients.appointments.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:08:00',
                'before_or_equal:19:45',
                function ($attribute, $value, $fail) {
                    [$hour, $minute] = explode(':', $value);

                    if ((int) $minute % 15 !== 0) {
                        $fail('Appointments must be scheduled in 15-minute intervals.');
                    }
                },
            ],
            'reason' => 'nullable|string|max:255',
        ]);

        $appointmentExists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->whereTime('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($appointmentExists) {
            return back()
                ->withErrors([
                    'appointment_time' => 'This doctor already has an appointment at the selected date and time. Please choose another time.',
                ])
                ->withInput();
        }

        $validated['patient_id'] = auth()->id();
        $validated['status'] = 'pending';

        Appointment::create($validated);

        return redirect()
            ->route('patient.appointments.index')
            ->with('success', 'Appointment booked successfully.');
    }

    public function availableTimes(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
        ]);

        $appointmentDate = Carbon::parse($request->appointment_date);

        $dayOfWeek = $appointmentDate->dayOfWeek;

        $workingHour = DoctorWorkingHour::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        $bookedTimes = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->values();

        return response()->json([
            'working_hours' => $workingHour ? [
                'start_time' => Carbon::parse($workingHour->start_time)->format('H:i'),
                'end_time' => Carbon::parse($workingHour->end_time)->format('H:i'),
            ] : null,

            'booked_times' => $bookedTimes,
        ]);
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->id()) {
            abort(403);
        }

        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->withErrors([
                'appointment' => 'This appointment cannot be cancelled.',
            ]);
        }

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('patient.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
