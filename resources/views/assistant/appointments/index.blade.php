@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')

<div class="page-header">

    <div>
        <h1>Appointments</h1>
        <p>Manage patient appointments</p>
    </div>

    <a href="{{ route('assistant.appointments.create') }}" class="btn btn-primary">
        + Add Appointment
    </a>

</div>

<div class="filter-card">
    <form action="{{ route('assistant.appointments.index') }}" method="GET" class="filter-form">
        <div class="filter-field">
            <label for="appointment_date">Filter by Date</label>
            <input
                type="date"
                name="appointment_date"
                id="appointment_date"
                value="{{ $appointmentDate }}"
            >
        </div>

        <div class="filter-actions">
            <button type="submit" class="primary-btn">
                Filter
            </button>

            @if ($appointmentDate)
                <a href="{{ route('assistant.appointments.index') }}" class="secondary-btn">
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

                    <td>
                        {{ $appointment->appointment_time }}
                    </td>

                    <td>
                        {{ ucfirst($appointment->status) }}
                    </td>

                    <td>

                        <div class="actions">

                            <a
                                href="{{ route('assistant.appointments.show', ['appointment' => $appointment->id]) }}"
                                class="btn btn-primary"
                            >
                                View
                            </a>

                            <a
                                href="{{ route('assistant.appointments.edit', ['appointment' => $appointment->id]) }}"
                                class="btn btn-secondary"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('assistant.appointments.destroy', ['appointment' => $appointment->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this appointment?')"
                            >

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
                    <td colspan="7">
                        No appointments found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
    <div class="pagination-wrapper">
    {{ $appointments->links() }}
    </div>

</div>

@endsection
