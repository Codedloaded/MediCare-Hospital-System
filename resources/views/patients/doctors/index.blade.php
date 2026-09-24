@extends('layouts.patient')

@section('title', 'Our Doctors')
@section('page-title', 'Our Doctors')

@section('content')

<div class="public-doctors-page">

    <div class="public-page-header">
        <p class="public-eyebrow">Our Medical Team</p>

        <h1>Meet Our Doctors</h1>

        <p>
            Our experienced medical professionals are here to provide
            trusted care across a wide range of specialties.
        </p>
    </div>

    <div class="public-doctors-grid">

        @forelse ($doctors as $doctor)

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

                    <span class="public-doctor-department">
                        {{ $doctor->department->name }}
                    </span>

                    <span class="public-doctor-link">
                        View Profile
                    </span>

                </div>

            </a>

        @empty

            <div class="public-empty-state">
                <h3>No doctors available</h3>
                <p>
                    There are currently no doctors available.
                </p>
            </div>

        @endforelse

    </div>

</div>

@endsection