@extends('layouts.admin')

@section('title', $doctor->name)

@section('content')

    <div class="page-header">
        <div>
            <h1>{{ $doctor->name }}</h1>
            <p>Doctor details</p>
        </div>

        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
            Back to Doctors
        </a>
    </div>

    <div class="form-container">

        <div class="form-group">
            <label>Doctor Name</label>
            <p>{{ $doctor->name }}</p>
        </div>

        <div class="form-group">
            <label>Department</label>
            <p>{{ $doctor->department->name }}</p>
        </div>

        <div class="form-group">
            <label>Specialization</label>
            <p>{{ $doctor->specialization }}</p>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <p>{{ $doctor->phone ?? 'N/A' }}</p>
        </div>

        <div class="form-group">
            <label>Email</label>
            <p>{{ $doctor->email ?? 'N/A' }}</p>
        </div>

        <div class="form-group">
            <label>Bio</label>
            <p>{{ $doctor->bio ?? 'No biography available.' }}</p>
        </div>

        <div class="form-actions">

            <a
                href="{{ route('doctors.edit', ['doctor' => $doctor->id]) }}"
                class="btn btn-secondary"
            >
                Edit Doctor
            </a>

            <a
                href="{{ route('doctors.index') }}"
                class="btn btn-primary"
            >
                Back
            </a>

        </div>

    </div>

@endsection