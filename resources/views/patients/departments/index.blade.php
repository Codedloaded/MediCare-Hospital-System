@extends('layouts.patient')

@section('title', 'Our Departments')
@section('page-title', 'Our Departments')

@section('content')

<div class="public-departments-page">

    <div class="public-page-header">
        <p class="public-eyebrow">Medical Specialties</p>

        <h1>Our Departments</h1>

        <p>
            Explore our medical departments and discover the specialized
            care available at MediCare Hospital.
        </p>
    </div>

    <div class="public-departments-grid">

        @forelse ($departments as $department)

            <a
                href="{{ route('public.departments.show', $department) }}"
                class="public-department-card"
            >

                <div class="public-department-image">

                    @if ($department->image)

                        <img
                            src="{{ asset('storage/' . $department->image) }}"
                            alt="{{ $department->name }}"
                        >

                    @else

                        <div class="public-department-placeholder">
                            +
                        </div>

                    @endif

                </div>

                <div class="public-department-info">

                    <h2>{{ $department->name }}</h2>

                    <p>
                        {{ $department->description ?? 'Specialized medical care provided by our experienced team.' }}
                    </p>

                    <div class="public-department-footer">
                        <span>
                            {{ $department->doctors_count }}
                            {{ Str::plural('Doctor', $department->doctors_count) }}
                        </span>

                        <span class="public-department-link">
                            View Department
                        </span>
                    </div>

                </div>

            </a>

        @empty

            <div class="public-empty-state">
                <h3>No departments available</h3>

                <p>
                    There are currently no departments available.
                </p>
            </div>

        @endforelse

    </div>

</div>

@endsection