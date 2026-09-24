
@extends('layouts.patient')

@section('title', 'Edit Profile')

@section('page-title', 'Edit Profile')

@section('content')

<div class="patient-page-header">

    <div>
        <h2>Edit Profile</h2>
        <p>Update your personal information and password.</p>
    </div>

</div>


<div class="patient-form-container">

    <form
        action="{{ route('patient.profile.update') }}"
        method="POST"
    >

        @csrf
        @method('PATCH')


        {{-- Personal Information --}}

        <div class="patient-form-section">

            <h3>Personal Information</h3>

            <p>
                Update your name and email address.
            </p>

        </div>


        <div class="patient-form-group">

            <label for="name">
                Full Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $patient->name) }}"
                required
            >

            @error('name')
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        <div class="patient-form-group">

            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $patient->email) }}"
                required
            >

            @error('email')
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Change Password --}}

        <div class="patient-form-section patient-password-section">

            <h3>Change Password</h3>

            <p>
                Leave the password fields empty if you don't want to change your password.
            </p>

        </div>


        <div class="patient-form-group">

            <label for="current_password">
                Current Password
            </label>

            <input
                type="password"
                id="current_password"
                name="current_password"
            >

            @error('current_password')
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        <div class="patient-form-group">

            <label for="password">
                New Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
            >

            @error('password')
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        <div class="patient-form-group">

            <label for="password_confirmation">
                Confirm New Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
            >

        </div>


        <div class="patient-form-actions">

            <a
                href="{{ route('patient.profile') }}"
                class="patient-secondary-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="patient-primary-btn"
            >
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection

