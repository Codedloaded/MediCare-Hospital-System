@extends('layouts.admin')

@section('title', 'Departments')

@section('content')

<div class="page-header">

    <div>
        <h1>Departments</h1>
        <p>View hospital departments and their doctors</p>
    </div>

</div>

<div class="table-container">

    <table>

        <thead>
            <tr>
                <th>#</th>
                <th>Department</th>
                <th>Description</th>
                <th>Doctors</th>
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
                        {{ $department->doctors->count() }}
                    </td>

                    <td>

                        <a
                            href="{{ route('assistant.departments.show', ['department' => $department->id]) }}"
                            class="btn btn-primary"
                        >
                            View
                        </a>

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