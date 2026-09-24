@extends('layouts.admin')

@section('title', 'Create Appointment')

@section('content')

    <div class="page-header">
        <div>
            <h1>Create Appointment</h1>
            <p>Schedule an appointment for a patient</p>
        </div>
    </div>

    <div class="form-container">

        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            {{-- Patient --}}

            <div class="form-group">

                <label for="patient_id">
                    Patient
                </label>

                <select
                    name="patient_id"
                    id="patient_id"
                    required
                >
                    <option value="">
                        Select a patient
                    </option>

                    @foreach ($patients as $patient)

                        <option
                            value="{{ $patient->id }}"
                            {{ old('patient_id', request('patient_id')) == $patient->id ? 'selected' : '' }}
                        >
                            {{ $patient->name }} — {{ $patient->email }}
                        </option>

                    @endforeach

                </select>

                @error('patient_id')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Department --}}

            <div class="form-group">

                <label for="department_id">
                    Department
                </label>

                <select
                    id="department_id"
                    required
                >

                    <option value="">
                        Select a department
                    </option>

                    @foreach ($doctors->groupBy('department_id') as $departmentId => $departmentDoctors)

                        @if ($departmentDoctors->first()->department)

                            <option value="{{ $departmentId }}">
                                {{ $departmentDoctors->first()->department->name }}
                            </option>

                        @endif

                    @endforeach

                </select>

            </div>


            {{-- Doctor --}}

            <div class="form-group">

                <label for="doctor_id">
                    Doctor
                </label>

                <select
                    name="doctor_id"
                    id="doctor_id"
                    required
                >

                    <option value="">
                        Select a doctor
                    </option>

                    @foreach ($doctors as $doctor)

                        <option
                            value="{{ $doctor->id }}"
                            data-department="{{ $doctor->department_id }}"
                        >
                            {{ $doctor->name }} — {{ $doctor->specialization }}
                        </option>

                    @endforeach

                </select>

                @error('doctor_id')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Date --}}

            <div class="form-group">

                <label for="appointment_date">
                    Appointment Date
                </label>

                <input
                    type="date"
                    name="appointment_date"
                    id="appointment_date"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('appointment_date') }}"
                    required
                >

                @error('appointment_date')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Time --}}

            <div class="form-group">

                <label>
                    Appointment Time
                </label>

                <input
                    type="hidden"
                    name="appointment_time"
                    id="appointment_time"
                    value="{{ old('appointment_time') }}"
                >

                <div
                    class="appointment-time-section"
                    id="appointment-time-section"
                >

                    <div
                        class="appointment-time-message"
                        id="appointment-time-message"
                    >
                        Select a doctor and date to see available times.
                    </div>

                    <div
                        class="appointment-time-group"
                        id="appointment-time-group"
                        style="display: none;"
                    >

                        <h4>Available Times</h4>

                        <div
                            class="appointment-time-grid"
                            id="appointment-time-grid"
                        >
                        </div>

                    </div>

                </div>

                <small class="form-help">
                    Each appointment lasts 15 minutes.
                </small>

                @error('appointment_time')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Reason --}}

            <div class="form-group">

                <label for="reason">
                    Reason
                </label>

                <textarea
                    name="reason"
                    id="reason"
                    rows="4"
                    placeholder="Reason for the appointment..."
                >{{ old('reason') }}</textarea>

                @error('reason')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- Actions --}}

            <div class="form-actions">

                <a
                    href="{{ route('appointments.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Create Appointment
                </button>

            </div>

        </form>

    </div>


    <script>

        const departmentSelect =
            document.getElementById('department_id');

        const doctorSelect =
            document.getElementById('doctor_id');

        const dateInput =
            document.getElementById('appointment_date');

        const appointmentTimeInput =
            document.getElementById('appointment_time');

        const doctorOptions =
            Array.from(
                doctorSelect.querySelectorAll(
                    'option[data-department]'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Doctor Filtering
        |--------------------------------------------------------------------------
        */

        function filterDoctors(departmentId, selectedDoctor = '') {

            doctorSelect.innerHTML = '';

            const defaultOption =
                document.createElement('option');

            defaultOption.value = '';
            defaultOption.textContent = 'Select a doctor';

            doctorSelect.appendChild(defaultOption);


            if (!departmentId) {
                resetTimeSlots();
                return;
            }


            doctorOptions.forEach(option => {

                if (
                    option.dataset.department === departmentId
                ) {

                    const newOption =
                        option.cloneNode(true);

                    if (
                        newOption.value === selectedDoctor
                    ) {
                        newOption.selected = true;
                    }

                    doctorSelect.appendChild(newOption);
                }

            });


            resetTimeSlots();
        }


        departmentSelect.addEventListener(
            'change',
            function () {

                filterDoctors(this.value);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Reset Time Slots
        |--------------------------------------------------------------------------
        */

        function resetTimeSlots() {

            appointmentTimeInput.value = '';

            const timeGrid =
                document.getElementById(
                    'appointment-time-grid'
                );

            const timeGroup =
                document.getElementById(
                    'appointment-time-group'
                );

            const message =
                document.getElementById(
                    'appointment-time-message'
                );


            timeGrid.innerHTML = '';

            timeGroup.style.display = 'none';

            message.style.display = 'block';

            message.textContent =
                'Select a doctor and date to see available times.';
        }


        /*
        |--------------------------------------------------------------------------
        | Time Helpers
        |--------------------------------------------------------------------------
        */

        function timeToMinutes(time) {

            const [hours, minutes] =
                time.split(':').map(Number);

            return (hours * 60) + minutes;
        }


        function minutesToTime(minutes) {

            const hours =
                Math.floor(minutes / 60);

            const mins =
                minutes % 60;

            return `${String(hours).padStart(2, '0')}:${String(mins).padStart(2, '0')}`;
        }


        function formatTime(time) {

            const [hours, minutes] =
                time.split(':').map(Number);

            const date = new Date();

            date.setHours(hours, minutes, 0, 0);

            return date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Load Available Times
        |--------------------------------------------------------------------------
        */

        async function loadAvailableTimes() {

            const doctorId =
                doctorSelect.value;

            const appointmentDate =
                dateInput.value;


            resetTimeSlots();


            if (!doctorId || !appointmentDate) {
                return;
            }


            try {

                const response = await fetch(
                    `{{ route('appointments.available-times') }}?doctor_id=${encodeURIComponent(doctorId)}&appointment_date=${encodeURIComponent(appointmentDate)}`
                );


                if (!response.ok) {

                    throw new Error(
                        `Request failed with status ${response.status}`
                    );

                }


                const data =
                    await response.json();


                console.log(
                    'Working hours:',
                    data.working_hours
                );

                console.log(
                    'Booked times:',
                    data.booked_times
                );


                const timeGrid =
                    document.getElementById(
                        'appointment-time-grid'
                    );

                const timeGroup =
                    document.getElementById(
                        'appointment-time-group'
                    );

                const message =
                    document.getElementById(
                        'appointment-time-message'
                    );


                timeGrid.innerHTML = '';


                if (!data.working_hours) {

                    timeGroup.style.display = 'none';

                    message.style.display = 'block';

                    message.textContent =
                        'This doctor is not available on the selected day.';

                    return;
                }


                message.style.display = 'none';

                timeGroup.style.display = 'block';


                const start =
                    timeToMinutes(
                        data.working_hours.start_time
                    );

                const end =
                    timeToMinutes(
                        data.working_hours.end_time
                    );


                const bookedTimes =
                    data.booked_times;


                for (
                    let minutes = start;
                    minutes < end;
                    minutes += 15
                ) {

                    const time =
                        minutesToTime(minutes);


                    const slot =
                        document.createElement('button');


                    slot.type = 'button';

                    slot.className =
                        'appointment-time-slot';

                    slot.dataset.time =
                        time;

                    slot.textContent =
                        formatTime(time);


                    if (bookedTimes.includes(time)) {

                        slot.disabled = true;

                        slot.classList.add(
                            'unavailable'
                        );

                    } else {

                        slot.addEventListener(
                            'click',
                            function () {

                                document
                                    .querySelectorAll(
                                        '.appointment-time-slot'
                                    )
                                    .forEach(item => {
                                        item.classList.remove(
                                            'selected'
                                        );
                                    });


                                this.classList.add(
                                    'selected'
                                );


                                appointmentTimeInput.value =
                                    this.dataset.time;

                            }
                        );

                    }


                    timeGrid.appendChild(slot);

                }


                if (timeGrid.children.length === 0) {

                    timeGroup.style.display = 'none';

                    message.style.display = 'block';

                    message.textContent =
                        'No appointment times are available for this doctor.';
                }

            } catch (error) {

                console.error(
                    'Unable to load appointment times:',
                    error
                );


                const message =
                    document.getElementById(
                        'appointment-time-message'
                    );


                message.style.display =
                    'block';

                message.textContent =
                    'Unable to load appointment times. Please try again.';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Doctor / Date Changes
        |--------------------------------------------------------------------------
        */

        doctorSelect.addEventListener(
            'change',
            loadAvailableTimes
        );

        dateInput.addEventListener(
            'change',
            loadAvailableTimes
        );


        /*
        |--------------------------------------------------------------------------
        | Initial Values
        |--------------------------------------------------------------------------
        */

        @if (old('department_id'))

            filterDoctors(
                '{{ old('department_id') }}',
                '{{ old('doctor_id') }}'
            );

        @endif

    </script>

@endsection
