@extends('layouts.admin')

@section('title', 'Edit Medical Assistant')
@section('page-title', 'Edit Medical Assistant')

@section('content')

<div class="page-header">

    <div>
        <h2>Edit Medical Assistant</h2>
        <p>Update the medical assistant account information.</p>
    </div>

</div>

<div class="form-card">

    <form
        action="{{ route('admin.medical-assistants.update', $medicalAssistant) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="name">Full Name</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $medicalAssistant->name) }}"
                required
            >

            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $medicalAssistant->email) }}"
                required
            >

            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="password">
                New Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
            >

            <small class="form-help">
                Leave this field empty if you don't want to change the password.
            </small>

            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="password_confirmation">
                Confirm New Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
            >

        </div>

        <div class="form-actions">

            <a
                href="{{ route('admin.medical-assistants.index') }}"
                class="secondary-btn"
            >
                Cancel
            </a>

            <button type="submit" class="primary-btn">
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection