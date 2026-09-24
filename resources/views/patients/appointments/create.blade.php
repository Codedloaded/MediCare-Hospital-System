@extends('layouts.patient')

@section('title', 'Book an Appointment')

@section('page-title', 'Book an Appointment')

@section('content')

<div class="patient-page-header">

    <div>
        <h2>Book an Appointment</h2>
        <p>Choose a doctor, date, and time for your appointment.</p>
    </div>

    <a
        href="{{ route('patient.appointments.index') }}"
        class="patient-secondary-btn"
    >
        Back to Appointments
    </a>

</div>


<div class="patient-form-container">

    <form
        action="{{ route('patient.appointments.store') }}"
        method="POST"
    >

        @csrf


        {{-- Department --}}

        <div class="patient-form-group">

            <label for="department_id">
                Department
            </label>

            <select
                name="department_id"
                id="department_id"
                required
            >

                <option value="">
                    Select a department
                </option>

                @foreach ($departments as $department)

                    <option
                        value="{{ $department->id }}"
                        {{ old('department_id') == $department->id ? 'selected' : '' }}
                    >
                        {{ $department->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Doctor --}}

        <div class="patient-form-group">

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

                @foreach ($departments as $department)

                    @foreach ($department->doctors as $doctor)

                        <option
                            value="{{ $doctor->id }}"
                            data-department="{{ $department->id }}"
                        >
                            {{ $doctor->name }} —
                            {{ $doctor->specialization }}
                        </option>

                    @endforeach

                @endforeach

            </select>

            @error('doctor_id')
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Date --}}

        <div class="patient-form-group">

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
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Time --}}

        <div class="patient-form-group">

            <label>
                Appointment Time
            </label>

            <input
                type="hidden"
                name="appointment_time"
                id="appointment_time"
                value="{{ old('appointment_time') }}"
            >

            <div class="appointment-time-section" id="appointment-time-section">

                <div class="appointment-time-message" id="appointment-time-message">
                    Select a doctor and date to see available times.
                </div>

                <div class="appointment-time-group" id="appointment-time-group" style="display: none;">

                    <h4>Available Times</h4>

                    <div class="appointment-time-grid" id="appointment-time-grid">
                    </div>

                </div>

            </div>

            <small class="patient-form-hint">
                Each appointment lasts 15 minutes.
            </small>

            @error('appointment_time')
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Reason --}}

        <div class="patient-form-group">

            <label for="reason">
                Reason for Visit
            </label>

            <textarea
                name="reason"
                id="reason"
                rows="4"
                placeholder="Briefly describe the reason for your appointment..."
            >{{ old('reason') }}</textarea>

            @error('reason')
                <span class="patient-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- Actions --}}

        <div class="patient-form-actions">

            <a
                href="{{ route('patient.appointments.index') }}"
                class="patient-secondary-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="patient-primary-btn"
            >
                Book Appointment
            </button>

        </div>

    </form>

</div>


<script>
console.log('Appointment JavaScript loaded');
const departmentSelect = document.getElementById('department_id');
const doctorSelect = document.getElementById('doctor_id');
const dateInput = document.getElementById('appointment_date');

const appointmentTimeInput =
    document.getElementById('appointment_time');

const appointmentTimeSlots =
    document.querySelectorAll('.appointment-time-slot');


/*
|--------------------------------------------------------------------------
| Doctor Filtering
|--------------------------------------------------------------------------
*/

const doctorOptions = Array.from(
    doctorSelect.querySelectorAll('option[data-department]')
);


function filterDoctors(departmentId, selectedDoctor = '') {

    doctorSelect.value = '';

    doctorOptions.forEach(option => {

        const matches =
            departmentId !== '' &&
            option.dataset.department === departmentId;

        option.hidden = !matches;

        if (matches && option.value === selectedDoctor) {
            option.selected = true;
        }

    });

}


departmentSelect.addEventListener('change', function () {

    filterDoctors(this.value);

    resetTimeSlots();

});


filterDoctors(
    departmentSelect.value,
    '{{ old('doctor_id') }}'
);


/*
|--------------------------------------------------------------------------
| Reset Time Slots
|--------------------------------------------------------------------------
*/

function resetTimeSlots() {

    appointmentTimeInput.value = '';

    const timeGrid = document.getElementById('appointment-time-grid');
    const timeGroup = document.getElementById('appointment-time-group');
    const message = document.getElementById('appointment-time-message');

    timeGrid.innerHTML = '';

    timeGroup.style.display = 'none';
    message.style.display = 'block';

    message.textContent =
        'Select a doctor and date to see available times.';
}


function loadAvailableTimes() {

    const doctorId = doctorSelect.value;
    const appointmentDate = dateInput.value;

    resetTimeSlots();

    if (!doctorId || !appointmentDate) {
        return;
    }

    fetch(
        `{{ route('patient.appointments.available-times') }}?doctor_id=${encodeURIComponent(doctorId)}&appointment_date=${encodeURIComponent(appointmentDate)}`
    )
        .then(response => {
            if (!response.ok) {
                throw new Error(
                    `Request failed with status ${response.status}`
                );
            }

            return response.json();
        })
        .then(data => {

            console.log('Working hours:', data.working_hours);
            console.log('Booked times:', data.booked_times);

            const timeGrid =
                document.getElementById('appointment-time-grid');

            const timeGroup =
                document.getElementById('appointment-time-group');

            const message =
                document.getElementById('appointment-time-message');

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

            const startTime = data.working_hours.start_time;
            const endTime = data.working_hours.end_time;

            const bookedTimes = data.booked_times;

            const start = timeToMinutes(startTime);
            const end = timeToMinutes(endTime);

            for (let minutes = start; minutes < end; minutes += 15) {

                const time = minutesToTime(minutes);

                const slot = document.createElement('button');

                slot.type = 'button';
                slot.className = 'appointment-time-slot';
                slot.dataset.time = time;

                slot.textContent = formatTime(time);

                if (bookedTimes.includes(time)) {

                    slot.disabled = true;
                    slot.classList.add('unavailable');

                } else {

                    slot.addEventListener('click', function () {

                        document
                            .querySelectorAll('.appointment-time-slot')
                            .forEach(item => {
                                item.classList.remove('selected');
                            });

                        this.classList.add('selected');

                        appointmentTimeInput.value =
                            this.dataset.time;
                    });
                }

                timeGrid.appendChild(slot);
            }

            if (timeGrid.children.length === 0) {

                timeGroup.style.display = 'none';
                message.style.display = 'block';

                message.textContent =
                    'No appointment times are available for this doctor.';
            }
        })
        .catch(error => {

            console.error(
                'Unable to load appointment times:',
                error
            );

            const message =
                document.getElementById('appointment-time-message');

            message.style.display = 'block';

            message.textContent =
                'Unable to load appointment times. Please try again.';
        });
}
function timeToMinutes(time) {

    const [hours, minutes] = time.split(':').map(Number);

    return (hours * 60) + minutes;
}


function minutesToTime(minutes) {

    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;

    return `${String(hours).padStart(2, '0')}:${String(mins).padStart(2, '0')}`;
}


function formatTime(time) {

    const [hours, minutes] = time.split(':').map(Number);

    const date = new Date();

    date.setHours(hours, minutes, 0, 0);

    return date.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
    });
}


/*
|--------------------------------------------------------------------------
| Select Time Slot
|--------------------------------------------------------------------------
*/

appointmentTimeSlots.forEach(slot => {

    slot.addEventListener('click', function () {

        if (this.disabled) {
            return;
        }

        appointmentTimeSlots.forEach(item => {
            item.classList.remove('selected');
        });

        this.classList.add('selected');

        appointmentTimeInput.value = this.dataset.time;

    });

});


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
| Load Existing Values After Validation Error
|--------------------------------------------------------------------------
*/

if (doctorSelect.value && dateInput.value) {
    loadAvailableTimes();
}

</script>

@endsection