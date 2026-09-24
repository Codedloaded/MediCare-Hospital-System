@extends('layouts.admin')

@section('title', $department->name)

@section('content')

    <div class="page-header">
        <div>
            <h1>{{ $department->name }}</h1>
            <p>Department details</p>
        </div>

        <a href="{{ route('departments.index') }}" class="btn btn-secondary">
            Back to Departments
        </a>
    </div>

    <div class="form-container">

        <div class="form-group">
            <label>Department Name</label>

            <p>
                {{ $department->name }}
            </p>
        </div>

        <div class="form-group">
            <label>Description</label>

            <p>
                {{ $department->description ?? 'No description available.' }}
            </p>
        </div>

        <div class="form-group">
            <label>Created At</label>

            <p>
                {{ $department->created_at->format('d M Y, h:i A') }}
            </p>
        </div>

        <div class="form-actions">

            <a
                href="{{ route('departments.edit', ['department' => $department->id]) }}"
                class="btn btn-secondary"
            >
                Edit Department
            </a>

            <a
                href="{{ route('departments.index') }}"
                class="btn btn-primary"
            >
                Back
            </a>

        </div>

    </div>

@endsection