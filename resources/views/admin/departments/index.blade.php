@extends('layouts.admin')

@section('title', 'Departments')

@section('content')

    <div class="page-header">
        <div>
            <h1>Departments</h1>
            <p>Manage hospital departments</p>
        </div>

        <a href="{{ route('departments.create') }}" class="btn btn-primary">
            + Add Department
        </a>
    </div>

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($departments as $department)

                    <tr>
                        <td>{{ $department->id }}</td>

                        <td>
                            <strong>{{ $department->name }}</strong>
                        </td>

                        <td>
                            {{ $department->description ?? 'No description' }}
                        </td>
                        <td>
                            @if ($department->image)
                                <img
                                    src="{{ asset('storage/' . $department->image) }}"
                                    alt="{{ $department->name }}"
                                    class="department-table-image"
                                >
                            @else
                                <div class="department-image-placeholder">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $department->created_at->format('d M Y') }}
                        </td>

                        <td>
                            <div class="actions">

                                <a
                                    href="{{ route('departments.show', ['department' => $department->id]) }}"
                                    class="btn btn-primary"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('departments.edit', ['department' => $department->id]) }}"
                                    class="btn btn-secondary"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('departments.destroy', ['department' => $department->id]) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this department?')"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">
                            No departments found.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
        <div class="pagination-wrapper">
        {{ $departments->links() }}
        </div>
    </div>

@endsection