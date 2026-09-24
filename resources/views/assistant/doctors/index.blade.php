@extends('layouts.admin')

@section('title', 'Doctors')

@section('content')

<div class="page-header">

    <div>
        <h1>Doctors</h1>
        <p>View hospital doctors and their information</p>
    </div>

</div>

<div class="filter-card">
    <form action="{{ route('assistant.doctors.index') }}" method="GET" class="filter-form">
        <div class="filter-field">
            <label for="search">Search Doctor</label>
            <input
                type="search"
                name="search"
                id="search"
                value="{{ $search }}"
                placeholder="Search by doctor name"
            >
        </div>

        <div class="filter-field">
            <label for="department_id">Department</label>
            <select name="department_id" id="department_id">
                <option value="">All departments</option>

                @foreach ($departments as $department)
                    <option
                        value="{{ $department->id }}"
                        {{ $departmentId === $department->id ? 'selected' : '' }}
                    >
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="primary-btn">
                Filter
            </button>

            @if ($search !== '' || $departmentId)
                <a href="{{ route('assistant.doctors.index') }}" class="secondary-btn">
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
                <th>Doctor</th>
                <th>Department</th>
                <th>Specialization</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($doctors as $doctor)

                <tr>

                    <td>{{ $doctor->id }}</td>

                    <td>
                        <strong>{{ $doctor->name }}</strong>
                    </td>

                    <td>
                        {{ $doctor->department->name }}
                    </td>

                    <td>
                        {{ $doctor->specialization }}
                    </td>

                    <td>
                        {{ $doctor->phone ?? '—' }}
                    </td>

                    <td>
                        {{ $doctor->email ?? '—' }}
                    </td>

                    <td>

                        <a
                            href="{{ route('assistant.doctors.show', ['doctor' => $doctor->id]) }}"
                            class="btn btn-primary"
                        >
                            View
                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7">
                        No doctors found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
    <div class="pagination-wrapper">
    {{ $doctors->links() }}
    </div>
</div>

@endsection
