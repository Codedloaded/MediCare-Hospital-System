@extends('layouts.admin')

@section('title', 'Medical Assistants')
@section('page-title', 'Medical Assistants')

@section('content')

<div class="page-header">

    <div>
        <h2>Medical Assistants</h2>
        <p>Manage hospital medical assistant accounts.</p>
    </div>

    <a
        href="{{ route('admin.medical-assistants.create') }}"
        class="primary-btn"
    >
        Add Medical Assistant
    </a>

</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-card">

    <table class="data-table">

        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($medicalAssistants as $assistant)

                <tr>

                    <td>
                        <strong>{{ $assistant->name }}</strong>
                    </td>

                    <td>
                        {{ $assistant->email }}
                    </td>

                    <td>
                        {{ $assistant->created_at->format('M d, Y') }}
                    </td>

                    <td>

                        <div class="table-actions">

                            <a
                                href="{{ route('admin.medical-assistants.edit', $assistant) }}"
                                class="table-edit-btn"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.medical-assistants.destroy', $assistant) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this medical assistant?');"
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
                    <td colspan="4" class="empty-state">
                        No medical assistants found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="pagination-wrapper">
    {{ $medicalAssistants->links() }}
</div>

@endsection