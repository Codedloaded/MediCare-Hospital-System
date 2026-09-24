
@extends('layouts.patient')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('content')

<div class="patient-page-header">

    <div>
        <h2>My Profile</h2>
        <p>View and manage your personal information.</p>
    </div>

</div>


@if (session('success'))

    <div class="patient-success">
        {{ session('success') }}
    </div>

@endif


<div class="patient-profile-card">

    <div class="patient-profile-header">

        <div class="patient-profile-user">

            <div class="patient-profile-avatar">
                {{ strtoupper(substr($patient->name, 0, 1)) }}
            </div>

            <div>
                <h2>{{ $patient->name }}</h2>
                <p>Patient</p>
            </div>

        </div>

        <a
            href="{{ route('patient.profile.edit') }}"
            class="patient-primary-btn"
        >
            Edit Profile
        </a>

    </div>


    <div class="patient-profile-details">

        <div class="patient-profile-field">

            <span>Full Name</span>

            <strong>
                {{ $patient->name }}
            </strong>

        </div>
        <div class="patient-profile-field">

            <span>Patient ID</span>

            <strong>
                #{{ $patient->id }}
            </strong>

        </div>


        <div class="patient-profile-field">

            <span>Email Address</span>

            <strong>
                {{ $patient->email }}
            </strong>

        </div>


        <div class="patient-profile-field">

            <span>Account Type</span>

            <strong>
                Patient
            </strong>

        </div>


        <div class="patient-profile-field">

            <span>Member Since</span>

            <strong>
                {{ $patient->created_at->format('M d, Y') }}
            </strong>

        </div>

    </div>

</div>

@endsection

