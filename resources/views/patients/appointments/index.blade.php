@extends('layouts.patient')

@section('title', 'My Appointments')

@section('page-title', 'My Appointments')

@section('content')

<div class="patient-page-header">

    <div>
        <h2>My Appointments</h2>
        <p>Track your upcoming and previous appointments.</p>
    </div>

    <a
        href="{{ route('patient.appointments.create') }}"
        class="patient-primary-btn"
    >
        + Book Appointment
    </a>

</div>


@if (session('success'))

    @php
        $bookedAppointment = session('appointment');
    @endphp

    <div class="patient-success">

        <strong>{{ session('success') }}</strong>

        @if ($bookedAppointment)

            <div class="patient-success-details">

                <span>
                    Doctor:
                    <strong>{{ $bookedAppointment->doctor->name }}</strong>
                </span>

                <span>
                    Department:
                    <strong>{{ $bookedAppointment->doctor->department->name }}</strong>
                </span>

                <span>
                    Date:
                    <strong>
                        {{ $bookedAppointment->appointment_date->format('M d, Y') }}
                    </strong>
                </span>

                <span>
                    Time:
                    <strong>
                        {{ \Carbon\Carbon::parse($bookedAppointment->appointment_time)->format('h:i A') }}
                    </strong>
                </span>

            </div>

        @endif

    </div>

@endif


@if ($errors->has('appointment'))

    <div class="patient-error-box">
        {{ $errors->first('appointment') }}
    </div>

@endif


{{-- Upcoming Appointments --}}

<div class="patient-section">

    <div class="patient-section-header">

        <div>
            <h2>Upcoming Appointments</h2>
            <p>Your scheduled appointments</p>
        </div>

    </div>


    <div class="patient-appointments">

        @forelse ($upcomingAppointments as $appointment)

            <div class="patient-appointment-card">

                <div class="patient-appointment-date">

                    <span>
                        {{ $appointment->appointment_date->format('M') }}
                    </span>

                    <strong>
                        {{ $appointment->appointment_date->format('d') }}
                    </strong>

                    <small>
                        {{ $appointment->appointment_date->format('Y') }}
                    </small>

                </div>


                <div class="patient-appointment-info">
                    <span class="patient-appointment-id">
                        Appointment ID: {{ $appointment->id }}
                    </span>
                    <h3>
                        {{ $appointment->doctor->name }}
                    </h3>

                    <p>
                        {{ $appointment->doctor->specialization }}
                    </p>

                    <span>
                        {{ $appointment->doctor->department->name }}
                    </span>

                    <div class="patient-appointment-time">
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </div>

                </div>


                <div class="patient-appointment-actions">

                    <span class="status-{{ $appointment->status }}">
                        {{ ucfirst($appointment->status) }}
                    </span>

                    <form
                        action="{{ route('patient.appointments.cancel', ['appointment' => $appointment->id]) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to cancel this appointment?')"
                    >

                        @csrf
                        @method('PATCH')

                        <button type="submit" class="patient-cancel-btn">
                            Cancel Appointment
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="empty-appointment">

                <h3>No upcoming appointments</h3>

                <p>
                    You don't have any upcoming appointments.
                </p>

                <a
                    href="{{ route('patient.appointments.create') }}"
                    class="patient-primary-btn"
                >
                    Book an Appointment
                </a>

            </div>

        @endforelse

    </div>

</div>


{{-- Appointment History --}}

<div class="patient-section">

    <div class="patient-section-header">

        <div>
            <h2>Appointment History</h2>
            <p>Your previous and cancelled appointments</p>
        </div>

    </div>


    <div class="patient-appointments">

        @forelse ($appointmentHistory as $appointment)

            <div class="patient-appointment-card">

                <div class="patient-appointment-date">

                    <span>
                        {{ $appointment->appointment_date->format('M') }}
                    </span>

                    <strong>
                        {{ $appointment->appointment_date->format('d') }}
                    </strong>

                    <small>
                        {{ $appointment->appointment_date->format('Y') }}
                    </small>

                </div>


                <div class="patient-appointment-info">
                    <span class="patient-appointment-id">
                        Appointment ID: {{ $appointment->id }}
                    </span>
                    <h3>
                        {{ $appointment->doctor->name }}
                    </h3>

                    <p>
                        {{ $appointment->doctor->specialization }}
                    </p>

                    <span>
                        {{ $appointment->doctor->department->name }}
                    </span>

                    <div class="patient-appointment-time">
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </div>

                </div>


                <div class="patient-appointment-actions">

                    <span class="status-{{ $appointment->status }}">
                        {{ ucfirst($appointment->status) }}
                    </span>

                </div>

            </div>

        @empty

            <div class="empty-appointment">

                <h3>No appointment history</h3>

                <p>
                    Your completed or cancelled appointments will appear here.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection