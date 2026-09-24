@extends('layouts.admin')

@section('title', 'Department Details')

@section('content')

<div class="page-header">

    <div>
        <h1>Department Details</h1>
        <p>View department information and doctors</p>
    </div>

    <a href="{{ route('assistant.departments.index') }}" class="btn btn-secondary">
        Back to Departments
    </a>

</div>

<div class="form-container">

    <div class="form-group">
        <label>Department Name</label>
        <p>{{ $department->name }}</p>
    </div>

    <div class="form-group">
        <label>Description</label>
        <p>{{ $department->description ?? 'No description provided.' }}</p>
    </div>

    <div class="form-group">

        <label>Doctors</label>

        @if ($department->doctors->count())

            <ul style="margin-top: 10px; padding-left: 20px;">

                @foreach ($department->doctors as $doctor)

                    <li style="margin-bottom: 8px;">
                        {{ $doctor->name }} — {{ $doctor->specialization }}
                    </li>

                @endforeach

            </ul>

        @else

            <p>No doctors assigned to this department.</p>

        @endif

    </div>

</div>

@endsection