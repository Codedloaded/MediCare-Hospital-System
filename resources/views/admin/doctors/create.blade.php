@extends('layouts.admin')

@section('title', 'Add Doctor')

@section('content')

    <div class="page-header">
        <div>
            <h1>Add Doctor</h1>
            <p>Add a new doctor to the hospital</p>
        </div>

        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
            Back to Doctors
        </a>
    </div>

    <div class="form-container">

        <form
            action="{{ route('doctors.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="form-group">
                <label for="name">Doctor Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Dr. Ahmed Mohamed"
                    required
                >

                @error('name')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="department_id">Department</label>

                <select
                    id="department_id"
                    name="department_id"
                    required
                >
                    <option value="">Select Department</option>

                    @foreach ($departments as $department)
                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id') == $department->id ? 'selected' : '' }}
                        >
                            {{ $department->name }}
                        </option>
                    @endforeach

                </select>

                @error('department_id')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="specialization">Specialization</label>

                <input
                    type="text"
                    id="specialization"
                    name="specialization"
                    value="{{ old('specialization') }}"
                    placeholder="e.g. Cardiologist"
                    required
                >

                @error('specialization')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="e.g. 01012345678"
                >

                @error('phone')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="doctor@example.com"
                >

                @error('email')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>

                <textarea
                    id="bio"
                    name="bio"
                    rows="5"
                    placeholder="Enter a short professional biography..."
                >{{ old('bio') }}</textarea>

                @error('bio')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Doctor Image</label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="form-help">
                    JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                </small>

                @error('image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">

                <a
                    href="{{ route('doctors.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Create Doctor
                </button>

            </div>

        </form>

    </div>

@endsection