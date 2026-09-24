@extends('layouts.admin')

@section('title', 'Add Medical Assistant')
@section('page-title', 'Add Medical Assistant')

@section('content')

<div class="page-header">

    <div>
        <h2>Add Medical Assistant</h2>
        <p>Create a new medical assistant account.</p>
    </div>

</div>

<div class="form-card">

    <form
        action="{{ route('admin.medical-assistants.store') }}"
        method="POST"
    >

        @csrf

        <div class="form-group">

            <label for="name">Full Name</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
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
                value="{{ old('email') }}"
                required
            >

            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label for="password_confirmation">
                Confirm Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
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
                Create Medical Assistant
            </button>

        </div>

    </form>

</div>

@endsection