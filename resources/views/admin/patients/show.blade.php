@extends('layouts.admin')

@section('title', 'Patient Details')

@section('content')

    <div class="page-header">
        <div>
            <h1>Patient Details</h1>
            <p>View patient information</p>
        </div>

        <a href="{{ route('patients.index') }}" class="btn btn-secondary">
            Back to Patients
        </a>
    </div>

    <div class="form-container">

        <div class="form-group">
            <label>Name</label>
            <p>{{ $patient->name }}</p>
        </div>

        <div class="form-group">
            <label>Email</label>
            <p>{{ $patient->email }}</p>
        </div>

        <div class="form-group">
            <label>Registered At</label>
            <p>{{ $patient->created_at->format('d M Y, h:i A') }}</p>
        </div>

    </div>

@endsection