@extends('layouts.patient')

@section('title', $doctor->name)
@section('page-title', 'Doctor Profile')

@section('content')

<div class="public-doctor-profile-page">

    <div class="public-profile-back">
        <a href="{{ route('public.doctors.index') }}">
            ← Back to Doctors
        </a>
    </div>

    <div class="public-doctor-profile">

        <div class="public-doctor-profile-image">

            @if ($doctor->image)

                <img
                    src="{{ asset('storage/' . $doctor->image) }}"
                    alt="{{ $doctor->name }}"
                >

            @else

                <div class="public-doctor-profile-placeholder">
                    {{ strtoupper(substr($doctor->name, 4, 1)) }}
                </div>

            @endif

        </div>

        <div class="public-doctor-profile-info">

            <p class="public-eyebrow">
                {{ $doctor->department->name }}
            </p>

            <h1>{{ $doctor->name }}</h1>

            <p class="public-doctor-profile-specialization">
                {{ $doctor->specialization }}
            </p>

            <div class="public-doctor-contact">

                @if ($doctor->phone)
                    <div>
                        <strong>Phone</strong>
                        <span>{{ $doctor->phone }}</span>
                    </div>
                @endif

                @if ($doctor->email)
                    <div>
                        <strong>Email</strong>
                        <span>{{ $doctor->email }}</span>
                    </div>
                @endif

            </div>

            @auth

                @if (auth()->user()->role === 'patient')

                    <a
                        href="{{ route('patient.appointments.create') }}"
                        class="public-primary-btn"
                    >
                        Book an Appointment
                    </a>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="public-primary-btn"
                    >
                        Patient Login to Book
                    </a>

                @endif

            @else

                <a
                    href="{{ route('login') }}"
                    class="public-primary-btn"
                >
                    Login to Book an Appointment
                </a>

            @endauth

        </div>

    </div>

    <div class="public-doctor-bio">

        <p class="public-eyebrow">About the Doctor</p>

        <h2>Professional Profile</h2>

        <p>
            {{ $doctor->bio ?? 'No biography is available for this doctor.' }}
        </p>

    </div>

</div>

@endsection