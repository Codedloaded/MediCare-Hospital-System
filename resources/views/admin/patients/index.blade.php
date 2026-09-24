@extends('layouts.admin')

@section('title', 'Patients')
@section('page-title', 'Patients')

@section('content')

<div class="page-header">

    <div>
        <h2>Patients</h2>
        <p>Manage registered hospital patients.</p>
    </div>

    <a
        href="{{ route('patients.create') }}"
        class="primary-btn"
    >
        Add Patient
    </a>

</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="filter-card">

    <form action="{{ route('patients.index') }}" method="GET" class="filter-form">

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
                <a href="{{ route('patients.index') }}" class="secondary-btn">
                    Clear
                </a>
            @endif
        </div>

    </form>

</div>

<div class="table-card">

    <table class="data-table">

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

                    <td>
                        {{ $patient->id }}
                    </td>

                    <td>
                        <strong>{{ $patient->name }}</strong>
                    </td>

                    <td>
                        {{ $patient->email }}
                    </td>

                    <td>
                        {{ $patient->created_at->format('d M Y') }}
                    </td>

                    <td>

                        <div class="table-actions">

                            <a
                                href="{{ route('patients.show', $patient) }}"
                                class="table-edit-btn"
                            >
                                View
                            </a>

                            <a
                                href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}"
                                class="table-edit-btn"
                            >
                                Book
                            </a>

                            <a
                                href="{{ route('patients.edit', $patient) }}"
                                class="table-edit-btn"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('patients.destroy', $patient) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this patient?');"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="table-delete-btn"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="empty-state">
                        No patients found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="pagination-wrapper">
    {{ $patients->links() }}
</div>

@endsection
