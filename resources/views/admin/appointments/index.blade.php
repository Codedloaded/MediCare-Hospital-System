@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')

    <div class="page-header">
        <div>
            <h1>Appointments</h1>
            <p>Manage patient appointments</p>
        </div>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
            + Add Appointment
        </a>
    </div>

    <div class="filter-card">

    <form
        action="{{ route('appointments.index') }}"
        method="GET"
        class="filter-form"
    >

        {{-- Patient Search --}}
        <div class="filter-field">

            <label for="patient_search">Patient</label>

            <input
                type="text"
                name="patient_search"
                id="patient_search"
                value="{{ $patientSearch }}"
                placeholder="Patient name or ID..."
            >

        </div>


        {{-- Doctor --}}
        <div class="filter-field">

            <label for="doctor_id">Doctor</label>

            <select name="doctor_id" id="doctor_id">

                <option value="">All Doctors</option>

                @foreach ($doctors as $doctor)

                    <option
                        value="{{ $doctor->id }}"
                        {{ $doctorId == $doctor->id ? 'selected' : '' }}
                    >
                        {{ $doctor->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Appointment ID --}}
        <div class="filter-field">

            <label for="appointment_id">Appointment ID</label>

            <input
                type="text"
                name="appointment_id"
                id="appointment_id"
                value="{{ $appointmentId }}"
                placeholder="Appointment ID..."
            >

        </div>


        {{-- Date --}}
        <div class="filter-field">

            <label for="appointment_date">Date</label>

            <input
                type="date"
                name="appointment_date"
                id="appointment_date"
                value="{{ $appointmentDate }}"
            >

        </div>


        {{-- Actions --}}
        <div class="filter-actions">

            <button type="submit" class="primary-btn">
                Search
            </button>

            @if ($patientSearch || $doctorId || $appointmentId || $appointmentDate)

                <a
                    href="{{ route('appointments.index') }}"
                    class="secondary-btn"
                >
                    Clear
                </a>

            @endif

        </div>

    </form>

</div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>

                        <td>
                            <strong>{{ $appointment->patient->name }}</strong>
                        </td>

                        <td>{{ $appointment->doctor->name }}</td>

                        <td>
                            {{ $appointment->appointment_date->format('d M Y') }}
                        </td>

                        <td>{{ $appointment->appointment_time }}</td>

                        <td>{{ ucfirst($appointment->status) }}</td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('appointments.show',['appointment'=> $appointment->id]) }}" class="btn btn-primary">
                                    View
                                </a>
                                <a href="{{ route('appointments.edit',['appointment'=> $appointment->id]) }}" class="btn btn-secondary">
                                    Edit
                                </a>
                                <form action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this appointment?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>

                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrapper">
            {{ $appointments->links() }}
        </div>  
    </div>

@endsection
