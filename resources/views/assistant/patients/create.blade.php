@extends('layouts.admin')

@section('title', 'Add Patient')

@section('content')

<div class="page-header">

    <div>
        <h1>Add Patient</h1>
        <p>Register a new hospital patient</p>
    </div>

    <a href="{{ route('assistant.patients.index') }}" class="btn btn-secondary">
        Back to Patients
    </a>

</div>

<div class="form-container">

    <form action="{{ route('assistant.patients.store') }}" method="POST">

        @csrf

        <div class="form-group">

            <label for="name">Patient Name</label>

            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                placeholder="Enter patient name"
                required
            >

            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="email">Email</label>

            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                placeholder="Enter patient email"
                required
            >

            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="password">Password</label>

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Enter password"
                required
            >

            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="password_confirmation">
                Confirm Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                placeholder="Confirm password"
                required
            >

        </div>

        <div class="form-actions">

            <a href="{{ route('assistant.patients.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                Add Patient
            </button>

        </div>

    </form>

</div>

@endsection