@extends('layouts.admin')

@section('title', 'Edit Department')

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Department</h1>
            <p>Update department information</p>
        </div>

        <a href="{{ route('departments.index') }}" class="btn btn-secondary">
            Back to Departments
        </a>
    </div>

    <div class="form-container">

        <form
            action="{{ route('departments.update', $department) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Department Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $department->name) }}"
                    required
                >

                @error('name')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                >{{ old('description', $department->description) }}</textarea>

                @error('description')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">

                <label for="image">Department Image</label>

                @if ($department->image)
                    <div class="current-image">
                        <img
                            src="{{ asset('storage/' . $department->image) }}"
                            alt="{{ $department->name }}"
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

            <div class="form-actions">

                <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Update Department
                </button>

            </div>

        </form>

    </div>

@endsection