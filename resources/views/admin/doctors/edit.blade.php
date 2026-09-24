@extends('layouts.admin')

@section('title', 'Edit Doctor')

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Doctor</h1>
            <p>Update doctor information</p>
        </div>

        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
            Back to Doctors
        </a>
    </div>

    <div class="form-container">

        <form
            action="{{ route('doctors.update', ['doctor' => $doctor->id]) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Doctor Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $doctor->name) }}"
                    required
                >

                @error('name')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="department_id">Department</label>

                <select id="department_id" name="department_id" required>

                    <option value="">Select Department</option>

                    @foreach ($departments as $department)
                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}
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
                    value="{{ old('specialization', $doctor->specialization) }}"
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
                    value="{{ old('phone', $doctor->phone) }}"
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
                    value="{{ old('email', $doctor->email) }}"
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
                >{{ old('bio', $doctor->bio) }}</textarea>

                @error('bio')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Doctor Image</label>

                @if ($doctor->image)
                    <div class="current-image">
                        <img
                            src="{{ asset('storage/' . $doctor->image) }}"
                            alt="{{ $doctor->name }}"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="form-help">
                    Leave empty to keep the current image. JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                </small>

                @error('image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <h3>Working Hours</h3>
                    <p>Set the doctor's working hours for each day of the week.</p>
                </div>

                @php
                    $days = [
                        0 => 'Sunday',
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                    ];

                    $workingHours = $doctor->workingHours->keyBy('day_of_week');
                @endphp

                <div class="doctor-working-hours">
                    @foreach ($days as $dayNumber => $dayName)
                        @php
                            $workingHour = $workingHours->get($dayNumber);
                        @endphp

                        <div class="doctor-working-day">

                            <div class="doctor-working-day-name">
                                <strong>{{ $dayName }}</strong>
                            </div>

                            <div class="doctor-working-day-fields">

                                <label>
                                    <span>Start Time</span>
                                    <input
                                        type="time"
                                        name="working_hours[{{ $dayNumber }}][start_time]"
                                        value="{{ $workingHour?->start_time ? \Carbon\Carbon::parse($workingHour->start_time)->format('H:i') : '' }}"
                                    >
                                </label>

                                <label>
                                    <span>End Time</span>
                                    <input
                                        type="time"
                                        name="working_hours[{{ $dayNumber }}][end_time]"
                                        value="{{ $workingHour?->end_time ? \Carbon\Carbon::parse($workingHour->end_time)->format('H:i') : '' }}"
                                    >
                                </label>

                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-actions">

                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Update Doctor
                </button>

            </div>

        </form>

    </div>

@endsection