@extends('layouts.admin')

@section('title', 'Edit Appointment')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit Appointment</h1>
        <p>Update appointment information</p>
    </div>

    <a href="{{ route('assistant.appointments.index') }}" class="btn btn-secondary">
        Back to Appointments
    </a>

</div>

<div class="form-container">

    <form
        action="{{ route('assistant.appointments.update', ['appointment' => $appointment->id]) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        {{-- Patient --}}
        <div class="form-group">

            <label for="patient_id">Patient</label>

            <select name="patient_id" id="patient_id" required>

                <option value="">Select a patient</option>

                @foreach ($patients as $patient)

                    <option
                        value="{{ $patient->id }}"
                        {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}
                    >
                        {{ $patient->name }} — {{ $patient->email }}
                    </option>

                @endforeach

            </select>

            @error('patient_id')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>


        {{-- Department --}}
        <div class="form-group">

            <label for="department_id">Department</label>

            <select name="department_id" id="department_id" required>

                <option value="">Select a department</option>

                @foreach ($doctors->groupBy('department_id') as $departmentId => $departmentDoctors)

                    @if ($departmentDoctors->first()->department)

                        <option
                            value="{{ $departmentId }}"
                            {{ old('department_id', $appointment->doctor->department_id) == $departmentId ? 'selected' : '' }}
                        >
                            {{ $departmentDoctors->first()->department->name }}
                        </option>

                    @endif

                @endforeach

            </select>

        </div>


        {{-- Doctor --}}
        <div class="form-group">

            <label for="doctor_id">Doctor</label>

            <select name="doctor_id" id="doctor_id" required>

                <option value="">Select a doctor</option>

                @foreach ($doctors as $doctor)

                    <option
                        value="{{ $doctor->id }}"
                        data-department="{{ $doctor->department_id }}"
                        {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}
                    >
                        {{ $doctor->name }} — {{ $doctor->specialization }}
                    </option>

                @endforeach

            </select>

            @error('doctor_id')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>


        {{-- Date --}}
        <div class="form-group">

            <label for="appointment_date">Date</label>

            <input
                type="date"
                name="appointment_date"
                id="appointment_date"
                value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}"
                min="{{ now()->format('Y-m-d') }}"
                required
            >

            @error('appointment_date')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>


        {{-- Hidden appointment time --}}
        <input
            type="hidden"
            name="appointment_time"
            id="appointment_time"
            value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}"
        >


        {{-- Available Times --}}
        <div class="appointment-time-section" id="appointment-time-section">

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
                ></div>

            </div>

        </div>


        @error('appointment_time')
            <span class="error">{{ $message }}</span>
        @enderror


        {{-- Status --}}
        <div class="form-group">

            <label for="status">Status</label>

            <select name="status" id="status" required>

                <option value="pending"
                    {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="confirmed"
                    {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>
                    Confirmed
                </option>

                <option value="completed"
                    {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>
                    Completed
                </option>

                <option value="cancelled"
                    {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>

            </select>

            @error('status')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>


        {{-- Reason --}}
        <div class="form-group">

            <label for="reason">Reason</label>

            <textarea
                name="reason"
                id="reason"
                rows="4"
                placeholder="Reason for the appointment..."
            >{{ old('reason', $appointment->reason) }}</textarea>

            @error('reason')
                <span class="error">{{ $message }}</span>
            @enderror

        </div>


        <div class="form-actions">

            <a
                href="{{ route('assistant.appointments.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                Update Appointment
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const departmentSelect =
        document.getElementById('department_id');

    const doctorSelect =
        document.getElementById('doctor_id');

    const dateInput =
        document.getElementById('appointment_date');

    const appointmentTimeInput =
        document.getElementById('appointment_time');

    const timeMessage =
        document.getElementById('appointment-time-message');

    const timeGroup =
        document.getElementById('appointment-time-group');

    const timeGrid =
        document.getElementById('appointment-time-grid');


    const currentAppointmentTime =
        "{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}";


    const allDoctorOptions = Array.from(
        doctorSelect.querySelectorAll('option[data-department]')
    );


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


        allDoctorOptions.forEach(option => {

            if (option.dataset.department === departmentId) {

                const newOption =
                    option.cloneNode(true);

                if (newOption.value === selectedDoctor) {
                    newOption.selected = true;
                }

                doctorSelect.appendChild(newOption);
            }

        });

    }


    function resetTimeSlots() {

        appointmentTimeInput.value = '';

        timeGrid.innerHTML = '';

        timeGroup.style.display = 'none';

        timeMessage.style.display = 'block';

        timeMessage.textContent =
            'Select a doctor and date to see available times.';

    }


    function formatTime(time) {

        const [hour, minute] =
            time.split(':');

        const date = new Date();

        date.setHours(
            parseInt(hour),
            parseInt(minute),
            0
        );

        return date.toLocaleTimeString([], {
            hour: 'numeric',
            minute: '2-digit'
        });

    }


    function generateTimeSlots(
        startTime,
        endTime,
        bookedTimes
    ) {

        timeGrid.innerHTML = '';

        let [startHour, startMinute] =
            startTime.split(':').map(Number);

        let [endHour, endMinute] =
            endTime.split(':').map(Number);


        let currentMinutes =
            startHour * 60 + startMinute;

        const endMinutes =
            endHour * 60 + endMinute;


        while (currentMinutes < endMinutes) {

            const hour =
                Math.floor(currentMinutes / 60);

            const minute =
                currentMinutes % 60;


            const time =
                String(hour).padStart(2, '0') +
                ':' +
                String(minute).padStart(2, '0');


            const button =
                document.createElement('button');

            button.type = 'button';

            button.className =
                'appointment-time-slot';

            button.textContent =
                formatTime(time);


            const isCurrentAppointment =
                time === currentAppointmentTime;


            const isBooked =
                bookedTimes.includes(time);


            if (isBooked && !isCurrentAppointment) {

                button.disabled = true;

                button.classList.add('booked');

                button.title =
                    'Already booked';

            } else {

                button.addEventListener(
                    'click',
                    function () {

                        document
                            .querySelectorAll(
                                '.appointment-time-slot'
                            )
                            .forEach(slot => {
                                slot.classList.remove(
                                    'selected'
                                );
                            });


                        button.classList.add(
                            'selected'
                        );

                        appointmentTimeInput.value =
                            time;

                    }
                );

            }


            if (
                time ===
                appointmentTimeInput.value
            ) {

                button.classList.add('selected');

            }


            timeGrid.appendChild(button);

            currentMinutes += 15;

        }

    }


    async function loadAvailableTimes() {

        const doctorId =
            doctorSelect.value;

        const appointmentDate =
            dateInput.value;


        appointmentTimeInput.value =
            appointmentTimeInput.value ||
            currentAppointmentTime;


        timeGrid.innerHTML = '';

        timeGroup.style.display =
            'none';


        if (!doctorId || !appointmentDate) {

            timeMessage.style.display =
                'block';

            timeMessage.textContent =
                'Select a doctor and date to see available times.';

            return;

        }


        timeMessage.style.display =
            'block';

        timeMessage.textContent =
            'Loading available times...';


        try {

            const response = await fetch(
                '{{ route('appointments.available-times') }}' +
                '?doctor_id=' +
                encodeURIComponent(doctorId) +
                '&appointment_date=' +
                encodeURIComponent(appointmentDate)
            );


            if (!response.ok) {
                throw new Error(
                    'Failed to load availability.'
                );
            }


            const data =
                await response.json();


            if (!data.working_hours) {

                timeMessage.textContent =
                    'The doctor is not working on the selected day.';

                return;

            }


            const bookedTimes =
                data.booked_times || [];


            generateTimeSlots(
                data.working_hours.start_time,
                data.working_hours.end_time,
                bookedTimes
            );


            timeMessage.style.display =
                'none';

            timeGroup.style.display =
                'block';


        } catch (error) {

            console.error(error);

            timeMessage.textContent =
                'Unable to load available times.';

        }

    }


    departmentSelect.addEventListener(
        'change',
        function () {

            filterDoctors(this.value);

            resetTimeSlots();

        }
    );


    doctorSelect.addEventListener(
        'change',
        function () {

            loadAvailableTimes();

        }
    );


    dateInput.addEventListener(
        'change',
        function () {

            loadAvailableTimes();

        }
    );


    filterDoctors(
        departmentSelect.value,
        '{{ old('doctor_id', $appointment->doctor_id) }}'
    );


    if (
        doctorSelect.value &&
        dateInput.value
    ) {

        loadAvailableTimes();

    }

});

</script>

@endsection