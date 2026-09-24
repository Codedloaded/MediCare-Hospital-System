<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Staff Login - MediCare Hospital</title>
</head>

<body>

<div class="login-page staff-login-page">

    <div class="login-card">

        <div class="login-header">
            <div class="login-logo">
                Medi<span>Care</span>
            </div>

            <h1>Staff Login</h1>

            <p>
                Sign in to access the hospital management system.
            </p>
        </div>

        <form action="{{ route('staff.login.submit') }}" method="POST">

            @csrf

            <div class="login-form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
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

            <button type="submit" class="login-button">
                Sign In
            </button>

        </form>

        <div class="login-footer">

            <p>
                Patient?
                <a href="{{ route('login') }}">Patient Login</a>
            </p>

        </div>

    </div>

</div>

</body>
</html>