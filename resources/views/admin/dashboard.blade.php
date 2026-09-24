@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">

    <div>
        <h1>Dashboard</h1>
        <p>Welcome to the Medicare Hospital admin panel.</p>
    </div>

</div>


<div class="cards">

    <a href="{{ route('departments.index') }}" class="card-link">
        <div class="card">
            <h3>Departments</h3>
            <p>{{ $departmentCount }}</p>
            <span>Total departments</span>
        </div>
    </a>


    <a href="{{ route('doctors.index') }}" class="card-link">
        <div class="card">
            <h3>Doctors</h3>
            <p>{{ $doctorCount }}</p>
            <span>Total doctors</span>
        </div>
    </a>


    <a href="{{ route('patients.index') }}" class="card-link">
        <div class="card">
            <h3>Patients</h3>
            <p>{{ $patientCount }}</p>
            <span>Total patients</span>
        </div>
    </a>


    <a href="{{ route('appointments.index') }}" class="card-link">
        <div class="card">
            <h3>Appointments</h3>
            <p>{{ $appointmentCount }}</p>
            <span>Total appointments</span>
        </div>
    </a>


    <a href="{{ route('appointments.index') }}" class="card-link">
        <div class="card">
            <h3>Today's Appointments</h3>
            <p>{{ $todayAppointmentCount }}</p>
            <span>Scheduled for today</span>
        </div>
    </a>


    <a href="{{ route('appointments.index') }}" class="card-link">
        <div class="card">
            <h3>Pending Appointments</h3>
            <p>{{ $pendingAppointmentCount }}</p>
            <span>Waiting for confirmation</span>
        </div>
    </a>


    <a href="{{ route('admin.medical-assistants.index') }}" class="card-link">
        <div class="card">
            <h3>Medical Assistants</h3>
            <p>{{ $medicalAssistantCount }}</p>
            <span>Total medical assistants</span>
        </div>
    </a>

</div>
<div class="dashboard-section">

    <div class="dashboard-section-header">

        <div>
            <h2>Today's Appointments</h2>
            <p>Appointments scheduled for today</p>
        </div>

        <a
            href="{{ route('appointments.index') }}"
            class="btn btn-secondary"
        >
            View All
        </a>

    </div>


    @if ($todayAppointments->count())

        <div class="table-container">

            <table class="admin-table">

                <thead>

                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($todayAppointments as $appointment)

                        <tr>

                            <td>
                                {{ $appointment->patient->name }}
                            </td>

                            <td>
                                {{ $appointment->doctor->name }}
                            </td>

                            <td>
                                {{ $appointment->doctor->department->name }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            </td>

                            <td>
                                <span class="status status-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                            <td>

                                <a
                                    href="{{ route('appointments.show', $appointment) }}"
                                    class="btn btn-secondary btn-sm"
                                >
                                    View
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-state">

            <h3>No appointments today</h3>

            <p>
                There are no appointments scheduled for today.
            </p>

        </div>

    @endif

</div>

@endsection