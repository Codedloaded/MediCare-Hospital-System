<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Patient Registration - MediCare Hospital</title>
</head>

<body>

<div class="login-page">

    <div class="login-card">

        <div class="login-header">

            <div class="login-logo">
                Medi<span>Care</span>
            </div>

            <h1>Create Patient Account</h1>

            <p>
                Register to access your patient portal.
            </p>

        </div>

        <form action="{{ route('register.submit') }}" method="POST">

            @csrf

            <div class="login-form-group">

                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                >

                @error('name')
                    <span class="login-error">{{ $message }}</span>
                @enderror

            </div>

            <div class="login-form-group">

                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >

                @error('email')
                    <span class="login-error">{{ $message }}</span>
                @enderror

            </div>

            <div class="login-form-group">

                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

                @error('password')
                    <span class="login-error">{{ $message }}</span>
                @enderror

            </div>

            <div class="login-form-group">

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

            <button type="submit" class="login-button">
                Create Account
            </button>

        </form>

        <div class="login-footer">

            <p>
                Already have an account?
                <a href="{{ route('login') }}">Patient Login</a>
            </p>

        </div>

    </div>

</div>

</body>
</html>