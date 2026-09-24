
@extends('layouts.patient')

@section('title', 'Patient Dashboard')

@section('page-title', 'Patient Dashboard')

@section('content')

<div class="patient-welcome">

    <div>
        <h2>Welcome back, {{ auth()->user()->name }}</h2>
        <p>Manage your healthcare appointments and explore our medical services.</p>
    </div>

    <a href="{{ route('patient.appointments.create') }}" class="patient-primary-btn">
        Book an Appointment
    </a>

</div>


{{-- Upcoming Appointment --}}

<div class="patient-section">

    <div class="patient-section-header">
        <div>
            <h2>Upcoming Appointment</h2>
            <p>Your next scheduled appointment</p>
        </div>
    </div>

    @if ($upcomingAppointment)

        <div class="upcoming-appointment">

            <div class="appointment-date">

                <span>
                    {{ $upcomingAppointment->appointment_date->format('M') }}
                </span>

                <strong>
                    {{ $upcomingAppointment->appointment_date->format('d') }}
                </strong>

            </div>

            <div class="appointment-info">

                <h3>
                    {{ $upcomingAppointment->doctor->name }}
                </h3>

                <p>
                    {{ $upcomingAppointment->doctor->specialization }}
                </p>

                <span>
                    {{ $upcomingAppointment->doctor->department->name }}
                    ·
                    {{ \Carbon\Carbon::parse($upcomingAppointment->appointment_time)->format('h:i A') }}
                </span>

            </div>

            <div class="appointment-status">
                {{ ucfirst($upcomingAppointment->status) }}
            </div>

        </div>

    @else

        <div class="empty-appointment">

            <h3>No upcoming appointments</h3>

            <p>
                You don't have any upcoming appointments.
            </p>

            <a href="{{ route('patient.appointments.create') }}" class="patient-primary-btn">
                Book Your First Appointment
            </a>

        </div>

    @endif

</div>


{{-- Quick Overview --}}

<div class="patient-stats">

    <div class="patient-stat-card">

        <span>Total Appointments</span>

        <strong>
            {{ $appointmentCount }}
        </strong>

    </div>

    <div class="patient-stat-card">

        <span>Departments</span>

        <strong>
            {{ \App\Models\Department::count() }}
        </strong>

    </div>

    <div class="patient-stat-card">

        <span>Doctors</span>

        <strong>
            {{ \App\Models\Doctor::count() }}
        </strong>

    </div>

</div>


{{-- Departments Preview --}}

<div class="patient-section">

    <div class="patient-section-header">

        <div>
            <h2>Our Departments</h2>
            <p>Explore our medical specialties</p>
        </div>

        <a href="{{ route('patient.departments.index') }}">
            View All
        </a>

    </div>


    <div class="patient-department-grid">

        @foreach ($departments as $department)

            <a
                href="{{ route('patient.departments.show', $department) }}"
                class="patient-department-card"
            >

                <div class="department-icon">
                    +
                </div>

                <h3>
                    {{ $department->name }}
                </h3>

                <p>
                    {{ $department->description ?? 'Specialized medical care from our professional team.' }}
                </p>

                <span>
                    {{ $department->doctors_count }} Doctors
                </span>

            </a>

        @endforeach

    </div>

</div>


{{-- Doctors Preview --}}

<div class="patient-section">

    <div class="patient-section-header">

        <div>
            <h2>Meet Our Doctors</h2>
            <p>Our experienced medical professionals</p>
        </div>

        <a href="{{ route('patient.doctors.index') }}">
            View All
        </a>

    </div>


    <div class="patient-doctor-grid">

        @foreach ($doctors as $doctor)

            <div class="patient-doctor-card">

                <div class="doctor-image">

                    @if ($doctor->image)

                        <img
                            src="{{ asset('storage/' . $doctor->image) }}"
                            alt="{{ $doctor->name }}"
                        >

                    @else

                        <div class="doctor-placeholder">
                            {{ strtoupper(substr($doctor->name, 4, 1)) }}
                        </div>

                    @endif

                </div>

                <div class="doctor-info">

                    <h3>
                        {{ $doctor->name }}
                    </h3>

                    <p>
                        {{ $doctor->specialization }}
                    </p>

                    <span>
                        {{ $doctor->department->name }}
                    </span>

                </div>

                <a href="{{ route('patient.doctors.show', $doctor) }}" class="doctor-view-btn">
                    View Profile
                </a>

            </div>

        @endforeach

    </div>

</div>

@endsection
