@extends('layouts.admin')

@section('title', 'Patients')

@section('content')

<div class="page-header">

    <div>
        <h1>Patients</h1>
        <p>View and register hospital patients</p>
    </div>

    <a href="{{ route('assistant.patients.create') }}" class="btn btn-primary">
        + Add Patient
    </a>

</div>

<div class="filter-card">

    <form action="{{ route('assistant.patients.index') }}" method="GET" class="filter-form">

        <div class="filter-field">
            <label for="search">Search Patient</label>

            <input
                type="search"
                name="search"
                id="search"
                value="{{ $search }}"
                placeholder="Search by name, email, or patient ID"
            >
        </div>

        <div class="filter-actions">
            <button type="submit" class="primary-btn">
                Search
            </button>

            @if ($search !== '')
                <a href="{{ route('assistant.patients.index') }}" class="secondary-btn">
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
                <th>Name</th>
                <th>Email</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($patients as $patient)

                <tr>

                    <td>{{ $patient->id }}</td>

                    <td>
                        <strong>{{ $patient->name }}</strong>
                    </td>

                    <td>{{ $patient->email }}</td>

                    <td>
                        {{ $patient->created_at->format('d M Y') }}
                    </td>

                    <td>
                        <a
                            href="{{ route('assistant.appointments.create', ['patient_id' => $patient->id]) }}"
                            class="btn btn-primary"
                        >
                            Book Appointment
                        </a>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5">
                        No patients found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
    <div class="pagination-wrapper">
    {{ $patients->links() }}
    </div>
</div>

@endsection
