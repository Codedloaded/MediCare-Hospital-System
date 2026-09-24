@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')

    <div class="page-header">
        <div>
            <h1>Appointment Details</h1>
            <p>View appointment information</p>
        </div>

        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
            Back to Appointments
        </a>
    </div>

    <div class="form-container">

        <div class="form-group">
            <label>Patient</label>
            <p>{{ $appointment->patient->name }}</p>
        </div>

        <div class="form-group">
            <label>Email</label>
            <p>{{ $appointment->patient->email }}</p>
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

        <div class="form-group">
            <label>Date</label>
            <p>{{ $appointment->appointment_date->format('d M Y') }}</p>
        </div>

        <div class="form-group">
            <label>Time</label>
            <p>{{ $appointment->appointment_time }}</p>
        </div>

        <div class="form-group">
            <label>Status</label>
            <p>{{ ucfirst($appointment->status) }}</p>
        </div>

        <div class="form-group">
            <label>Reason</label>
            <p>{{ $appointment->reason ?? 'No reason provided.' }}</p>
        </div>

    </div>

@endsection