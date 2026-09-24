@extends('layouts.admin')

@section('title', 'Add Department')

@section('content')

    <div class="page-header">
        <div>
            <h1>Add Department</h1>
            <p>Create a new hospital department</p>
        </div>

        <a href="{{ route('departments.index') }}" class="btn btn-primary">
            Back to Departments
        </a>
    </div>

    <div class="form-container">

        <form
            action="{{ route('departments.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="form-group">
                <label for="name">Department Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Cardiology"
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
                    placeholder="Enter department description..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">

                <label for="image">Department Image</label>

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
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Create Department
                </button>
            </div>

        </form>

    </div>

@endsection