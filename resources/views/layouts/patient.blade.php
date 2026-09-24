<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Patient Portal') - Medicare Hospital</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

<div class="patient-layout">

    <aside class="patient-sidebar">

        <div class="patient-logo">
            Medicare <span>Hospital</span>
        </div>

        <nav>
            <a
                href="{{ route('home') }}"
                class="patient-nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
            >
                Home
            </a>

            @auth

                <a
                    href="{{ route('patient.dashboard') }}"
                    class="patient-nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('patient.appointments.index') }}"
                    class="patient-nav-link {{ request()->routeIs('patient.appointments.*') ? 'active' : '' }}"
                >
                    My Appointments
                </a>

            @endauth

            <a
                href="{{ route('public.doctors.index') }}"
                class="patient-nav-link {{ request()->routeIs('public.doctors.*') ? 'active' : '' }}"
            >
                Doctors
            </a>

            <a
                href="{{ route('public.departments.index') }}"
                class="patient-nav-link {{ request()->routeIs('public.departments.*') ? 'active' : '' }}"
            >
                Departments
            </a>

            @auth

                <a
                    href="{{ route('patient.profile') }}"
                    class="patient-nav-link {{ request()->routeIs('patient.profile*') ? 'active' : '' }}"
                >
                    My Profile
                </a>

            @endauth

        </nav>

        <div class="patient-sidebar-bottom">

            @auth

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button type="submit" class="patient-logout">
                        Logout
                    </button>

                </form>

            @else

                <a
                    href="{{ route('login') }}"
                    class="patient-login-btn"
                >
                    Patient Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="patient-register-btn"
                >
                    Create Account
                </a>

            @endauth

        </div>

    </aside>


    <main class="patient-main">

        <header class="patient-navbar">

            <div>
                <h1>@yield('page-title', 'Patient Portal')</h1>
            </div>

            <div class="patient-user">

                @auth
                    <span>
                        {{ auth()->user()->name }}
                    </span>
                @else
                    <a href="{{ route('login') }}">
                        Patient Login
                    </a>
                @endauth

            </div>

        </header>


        <section class="patient-content">

            @yield('content')

        </section>

    </main>

</div>

</body>

</html>