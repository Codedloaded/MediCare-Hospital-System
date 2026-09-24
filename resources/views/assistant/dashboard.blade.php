@extends('layouts.admin')

@section('title', 'Medical Assistant Dashboard')

@section('content')

<div class="page-header">

    <div>
        <h1>Medical Assistant Dashboard</h1>
        <p>Manage patients and appointments</p>
    </div>

</div>

<div class="cards">

    <a href="{{ route('assistant.patients.index') }}" class="card-link">

        <div class="card">

            <h3>Patients</h3>

            <div class="number">
                View
            </div>

        </div>

    </a>

    <a href="{{ route('assistant.appointments.index') }}" class="card-link">

        <div class="card">

            <h3>Appointments</h3>

            <div class="number">
                View
            </div>

        </div>

    </a>

    <a href="{{ route('assistant.doctors.index') }}" class="card-link">

        <div class="card">

        <h3>Doctors</h3>

        <div class="number">
            View
        </div>

    </div>
    </a>
    <a href="{{ route('assistant.doctors.index') }}" class="card-link">

        <div class="card">

        <h3>Departments</h3>

        <div class="number">
            View
        </div>

    </div>

    </a>

    
</div>

<div class="table-container">

    <h2>Welcome, {{ auth()->user()->name }}</h2>

    <p style="margin-top: 10px; color: #64748b;">
        You can register new patients and manage hospital appointments
        from this dashboard.
    </p>

</div>

@endsection