<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>MediCare Hospital</title>

</head>

<body>

<header class="public-header">

    <div class="public-container">

        <a href="{{ route('home') }}" class="public-logo">
            Medi<span>Care</span>
        </a>

        <nav class="public-nav">

            <a href="{{ route('home') }}">
                Home
            </a>

            <a href="{{ route('public.departments.index') }}">
                Departments
            </a>

            <a href="{{ route('public.doctors.index') }}">
                Doctors
            </a>

            @auth

                <a href="{{ route('patient.dashboard') }}">
                    Dashboard
                </a>

            @else

                <a href="{{ route('login') }}">
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="public-nav-button"
                >
                    Register
                </a>

            @endauth

        </nav>

    </div>

</header>


<main>

    <section class="public-hero">

        <img
            src="{{ asset('images/hero.jpg') }}"
            alt="MediCare Hospital"
            class="public-hero-image"
        >

        <div class="public-hero-content">
            <div class="public-hero-text">
                <p class="public-eyebrow">Quality Healthcare You Can Trust</p>

                <h1>Your Health Is Our <span>Priority.</span></h1>

                <p>
                    At MediCare Hospital, we provide professional medical
                    care with experienced doctors and modern healthcare
                    services designed around our patients.
                </p>

                <div class="public-hero-actions">
                    <a href="{{ route('public.doctors.index') }}" class="public-primary-btn">
                        Meet Our Doctors
                    </a>

                    <a href="{{ route('public.departments.index') }}" class="public-secondary-btn">
                        Explore Departments
                    </a>
                </div>
            </div>
        </div>

    </section>


    <section class="public-section">

        <div class="public-container">

            <div class="public-section-header">

                <p class="public-eyebrow">
                    Our Services
                </p>

                <h2>
                    Medical Care Across Multiple Specialties
                </h2>

                <p>
                    Explore our departments and find the right specialist
                    for your healthcare needs.
                </p>

            </div>


            <div class="public-feature-grid">

                <div class="public-feature-card">

                    <h3>Experienced Doctors</h3>

                    <p>
                        Our medical team includes experienced professionals
                        across a wide range of specialties.
                    </p>

                </div>


                <div class="public-feature-card">

                    <h3>Specialized Departments</h3>

                    <p>
                        Explore our medical departments and the services
                        available at MediCare Hospital.
                    </p>

                </div>


                <div class="public-feature-card">

                    <h3>Easy Appointments</h3>

                    <p>
                        Find a doctor and request an appointment through
                        our patient portal.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <section class="public-cta">

        <div class="public-container">

            <h2>
                Ready to Take Care of Your Health?
            </h2>

            <p>
                Create your patient account and book your appointment
                with one of our doctors.
            </p>

            @auth

                <a
                    href="{{ route('patient.appointments.create') }}"
                    class="public-primary-btn"
                >
                    Book an Appointment
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="public-primary-btn"
                >
                    Login to Book an Appointment
                </a>

            @endauth

        </div>

    </section>

</main>


<footer class="public-footer">

    <div class="public-container">

        <p>
            © {{ date('Y') }} MediCare Hospital. All rights reserved.
        </p>

    </div>

</footer>

</body>

</html>