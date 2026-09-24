@extends('layouts.patient')

@section('title', $department->name)
@section('page-title', 'Department Profile')

@section('content')

<div class="public-department-profile-page">

    <div class="public-profile-back">
        <a href="{{ route('public.departments.index') }}">
            ← Back to Departments
        </a>
    </div>

    <div class="public-department-profile">

        <div class="public-department-profile-header">

            <div class="public-department-profile-image">

                @if ($department->image)

                    <img
                        src="{{ asset('storage/' . $department->image) }}"
                        alt="{{ $department->name }}"
                    >

                @else

                    <div class="public-department-profile-placeholder">
                        +
                    </div>

                @endif

            </div>

            <div class="public-department-profile-info">

                <p class="public-eyebrow">
                    Medical Department
                </p>

                <h1>{{ $department->name }}</h1>

                <p>
                    {{ $department->description ?? 'Specialized medical care provided by our experienced medical team.' }}
                </p>

                <span class="public-department-doctor-count">
                    {{ $department->doctors->count() }}
                    {{ Str::plural('Doctor', $department->doctors->count()) }}
                </span>

            </div>

        </div>

    </div>

    <div class="public-department-doctors">

        <div class="public-page-header">
            <p class="public-eyebrow">Medical Team</p>

            <h2>Doctors in {{ $department->name }}</h2>

            <p>
                Meet the doctors providing specialized care in this department.
            </p>
        </div>

        <div class="public-doctors-grid">

            @forelse ($department->doctors as $doctor)

                <a
                    href="{{ route('public.doctors.show', $doctor) }}"
                    class="public-doctor-card"
                >

                    <div class="public-doctor-image">

                        @if ($doctor->image)

                            <img
                                src="{{ asset('storage/' . $doctor->image) }}"
                                alt="{{ $doctor->name }}"
                            >

                        @else

                            <div class="public-doctor-placeholder">
                                {{ strtoupper(substr($doctor->name, 4, 1)) }}
                            </div>

                        @endif

                    </div>

                    <div class="public-doctor-info">

                        <h2>{{ $doctor->name }}</h2>

                        <p class="public-doctor-specialization">
                            {{ $doctor->specialization }}
                        </p>

                        <span class="public-doctor-link">
                            View Profile
                        </span>

                    </div>

                </a>

            @empty

                <div class="public-empty-state">

                    <h3>No doctors available</h3>

                    <p>
                        There are currently no doctors assigned to this department.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection