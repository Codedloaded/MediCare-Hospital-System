<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Admin Dashboard') - MediCare</title>

</head>

<body>

<div class="admin-layout">

    <aside class="sidebar">

    <div class="logo">
        Medi<span>Care</span>
    </div>

    <div class="sidebar-role">
        @if (auth()->user()->role === 'admin')
            Administration
        @elseif (auth()->user()->role === 'medical_assistant')
            Medical Assistant
        @endif
    </div>

    <nav class="sidebar-nav">

        @if (auth()->user()->role === 'admin')

    <a
        href="{{ route('admin.dashboard') }}"
        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
    >
        <span>Dashboard</span>
    </a>

    <div class="sidebar-section-title">
        Management
    </div>

    <a
        href="{{ route('departments.index') }}"
        class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}"
    >
        <span>Departments</span>
    </a>

    <a
        href="{{ route('doctors.index') }}"
        class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}"
    >
        <span>Doctors</span>
    </a>

    <a
        href="{{ route('patients.index') }}"
        class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}"
    >
        <span>Patients</span>
    </a>
    <a
        href="{{ route('admin.medical-assistants.index') }}"
        class="nav-link {{ request()->routeIs('admin.medical-assistants.*') ? 'active' : '' }}"
    >
        <span>Medical Assistants</span>
    </a>

    <a
        href="{{ route('appointments.index') }}"
        class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}"
    >
        <span>Appointments</span>
    </a>


@elseif (auth()->user()->role === 'medical_assistant')

    <a
        href="{{ route('assistant.dashboard') }}"
        class="nav-link {{ request()->routeIs('assistant.dashboard') ? 'active' : '' }}"
    >
        <span>Dashboard</span>
    </a>

    <div class="sidebar-section-title">
        Patient Care
    </div>

    <a
        href="{{ route('assistant.patients.index') }}"
        class="nav-link {{ request()->routeIs('assistant.patients.*') ? 'active' : '' }}"
    >
        <span>Patients</span>
    </a>

    <a
        href="{{ route('assistant.appointments.index') }}"
        class="nav-link {{ request()->routeIs('assistant.appointments.*') ? 'active' : '' }}"
    >
        <span>Appointments</span>
    </a>

    <a
        href="{{ route('assistant.doctors.index') }}"
        class="nav-link {{ request()->routeIs('assistant.doctors.*') ? 'active' : '' }}"
    >
        <span>Doctors</span>
    </a>

    <a
        href="{{ route('assistant.departments.index') }}"
        class="nav-link {{ request()->routeIs('assistant.departments.*') ? 'active' : '' }}"
    >
        <span>Departments</span>
    </a>

@endif

    </nav>

    <div class="sidebar-bottom">

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="sidebar-user-info">
                <strong>{{ auth()->user()->name }}</strong>

                <span>
                    @if (auth()->user()->role === 'admin')
                        Administrator
                    @else
                        Medical Assistant
                    @endif
                </span>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="sidebar-logout">
                Logout
            </button>
        </form>

    </div>

</aside>

    <main class="main">

        <div class="topbar">

            <h1>
                @yield('page-title', 'Dashboard')
            </h1>

            <div class="admin-name">
                {{ auth()->user()->name }}
            </div>

        </div>


        @yield('content')

    </main>

</div>

</body>
</html>