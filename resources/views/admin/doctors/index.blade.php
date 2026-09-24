@extends('layouts.admin')

@section('title', 'Doctors')

@section('content')

    <div class="page-header">
        <div>
            <h1>Doctors</h1>
            <p>Manage hospital doctors</p>
        </div>

        <a href="{{ route('doctors.create') }}" class="btn btn-primary">
            + Add Doctor
        </a>
    </div>

    <div class="filter-card">
        <form action="{{ route('doctors.index') }}" method="GET" class="filter-form">
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
                    <a href="{{ route('doctors.index') }}" class="secondary-btn">
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
                    <th>Image</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Specialization</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($doctors as $doctor)

                    <tr>
                        <td>{{ $doctor->id }}</td>
                        <td>
                            @if ($doctor->image)
                                <img
                                    src="{{ asset('storage/' . $doctor->image) }}"
                                    alt="{{ $doctor->name }}"
                                    class="doctor-table-image"
                                >
                            @else
                                <div class="doctor-image-placeholder">
                                    No Image
                                </div>
                            @endif
                        </td>

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
                            {{ $doctor->phone ?? 'N/A' }}
                        </td>

                        <td>
                            <div class="actions">

                                <a
                                    href="{{ route('doctors.show', ['doctor' => $doctor->id]) }}"
                                    class="btn btn-primary"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('doctors.edit', ['doctor' => $doctor->id]) }}"
                                    class="btn btn-secondary"
                                >
                                    Edit
                                </a>
                                <form
                                    action="{{ route('doctors.destroy', ['doctor' => $doctor->id]) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this doctor?')"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </div>
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
