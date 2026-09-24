@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')

<div class="page-header">

    <div>
        <h1>Appointment Details</h1>
        <p>Review complete appointment information</p>
    </div>

    <a
        href="{{ route('assistant.appointments.index') }}"
        class="btn btn-secondary"
    >
        Back to Appointments
    </a>

</div>


<div class="form-container">

    <div class="admin-form-section">

        <div class="admin-form-section-header">
            <h3>Patient Information</h3>
            <p>Information about the patient.</p>
        </div>

        <div class="form-group">
            <label>Patient</label>
            <p>{{ $appointment->patient->name }}</p>
        </div>

        <div class="form-group">
            <label>Email</label>
            <p>{{ $appointment->patient->email }}</p>
        </div>

    </div>


    <div class="admin-form-section">

        <div class="admin-form-section-header">
            <h3>Doctor Information</h3>
            <p>Information about the assigned doctor.</p>
        </div>

        <div class="form-group">
            <label>Doctor</label>
            <p>{{ $appointment->doctor->name }}</p>
        </div>

        <div class="form-group">
            <label>Department</label>
            <p>{{ $appointment->doctor->department->name }}</p>
        </div>

        <div class="form-group">
            <label>Specialization</label>
            <p>{{ $appointment->doctor->specialization }}</p>
        </div>

    </div>


    <div class="admin-form-section">

        <div class="admin-form-section-header">
            <h3>Appointment Information</h3>
            <p>Scheduled appointment details.</p>
        </div>

        <div class="form-group">
            <label>Date</label>
            <p>
                {{ $appointment->appointment_date->format('d M Y') }}
            </p>
        </div>

        <div class="form-group">
            <label>Time</label>
            <p>
                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
            </p>
        </div>

        <div class="form-group">
            <label>Status</label>
            <p>{{ ucfirst($appointment->status) }}</p>
        </div>

        <div class="form-group">
            <label>Reason</label>
            <p>
                {{ $appointment->reason ?? 'No reason provided.' }}
            </p>
        </div>

    </div>


    <div class="form-actions">

        <a
            href="{{ route('assistant.appointments.edit', $appointment) }}"
            class="btn btn-primary"
        >
            Edit Appointment
        </a>

        <a
            href="{{ route('assistant.appointments.index') }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>

</div>

@endsection