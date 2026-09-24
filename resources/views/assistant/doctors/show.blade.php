@extends('layouts.admin')

@section('title', 'Doctor Details')

@section('content')

<div class="page-header">

    <div>
        <h1>Doctor Details</h1>
        <p>View doctor information</p>
    </div>

    <a href="{{ route('assistant.doctors.index') }}" class="btn btn-secondary">
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
        <p>{{ $doctor->phone ?? 'Not provided' }}</p>
    </div>

    <div class="form-group">
        <label>Email</label>
        <p>{{ $doctor->email ?? 'Not provided' }}</p>
    </div>

    <div class="form-group">
        <label>Bio</label>
        <p>{{ $doctor->bio ?? 'No biography provided.' }}</p>
    </div>

</div>

@endsection