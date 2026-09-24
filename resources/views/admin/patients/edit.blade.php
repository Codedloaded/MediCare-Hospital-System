@extends('layouts.admin')

@section('title', 'Edit Patient')

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Patient</h1>
            <p>Update patient information</p>
        </div>
    </div>

    <div class="form-container">

        <form action="{{ route('patients.update', ['patient' => $patient->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $patient->name) }}"
                    required
                >

                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $patient->email) }}"
                    required
                >

                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Update Patient
                </button>
            </div>

        </form>

    </div>

@endsection