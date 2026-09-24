<?php

use App\Http\Controllers\admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\MedicalAssistantController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Assistant\AppointmentController as AssistantAppointmentController;
use App\Http\Controllers\Assistant\DashboardController as AssistantDashboardController;
use App\Http\Controllers\Assistant\DepartmentController as AssistantDepartmentController;
use App\Http\Controllers\Assistant\DoctorController as AssistantDoctorController;
use App\Http\Controllers\Assistant\PatientController as AssistantPatientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\DepartmentController as PatientDepartmentController;
use App\Http\Controllers\Patient\DoctorController as PatientDoctorController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/staff/login', [LoginController::class, 'showStaffLoginForm'])
    ->name('staff.login');

Route::post('/staff/login', [LoginController::class, 'staffLogin'])
    ->name('staff.login.submit');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.submit');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('admin/departments', DepartmentController::class);

    Route::resource('admin/doctors', DoctorController::class);

    Route::resource('admin/patients', PatientController::class);

    Route::resource('admin/appointments', AppointmentController::class);
    Route::resource(
        'admin/medical-assistants',
        MedicalAssistantController::class
    )->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ])
        ->names([
                'index' => 'admin.medical-assistants.index',
                'create' => 'admin.medical-assistants.create',
                'store' => 'admin.medical-assistants.store',
                'edit' => 'admin.medical-assistants.edit',
                'update' => 'admin.medical-assistants.update',
                'destroy' => 'admin.medical-assistants.destroy',
            ]);

});
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth', 'medical_assistant'])->group(function () {

    Route::get('/assistant/dashboard', [AssistantDashboardController::class, 'index'])
        ->name('assistant.dashboard');
    Route::resource('assistant/patients', AssistantPatientController::class)
        ->only(['index', 'create', 'store'])
        ->names([
            'index' => 'assistant.patients.index',
            'create' => 'assistant.patients.create',
            'store' => 'assistant.patients.store',
        ]);
    Route::resource('assistant/appointments', AssistantAppointmentController::class)
        ->names([
            'index' => 'assistant.appointments.index',
            'create' => 'assistant.appointments.create',
            'store' => 'assistant.appointments.store',
            'show' => 'assistant.appointments.show',
            'edit' => 'assistant.appointments.edit',
            'update' => 'assistant.appointments.update',
            'destroy' => 'assistant.appointments.destroy',
        ]);
    Route::resource('assistant/doctors', AssistantDoctorController::class)
        ->only(['index', 'show'])
        ->names([
            'index' => 'assistant.doctors.index',
            'show' => 'assistant.doctors.show',
        ]);
    Route::resource('assistant/departments', AssistantDepartmentController::class)
        ->only(['index', 'show'])
        ->names([
            'index' => 'assistant.departments.index',
            'show' => 'assistant.departments.show',
        ]);

});

Route::resource('doctors', PatientDoctorController::class)
    ->only(['index', 'show'])
    ->names([
        'index' => 'public.doctors.index',
        'show' => 'public.doctors.show',
    ]);
Route::resource('departments', PatientDepartmentController::class)
    ->only(['index', 'show'])
    ->names([
        'index' => 'public.departments.index',
        'show' => 'public.departments.show',
    ]);

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/appointments/available-times',
        [PatientAppointmentController::class, 'availableTimes']
    )->name('appointments.available-times');

});
Route::middleware(['auth', 'patient'])->group(function () {

    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])
        ->name('patient.dashboard');
    Route::resource('patient/doctors', PatientDoctorController::class)
        ->only(['index', 'show'])
        ->names([
            'index' => 'patient.doctors.index',
            'show' => 'patient.doctors.show',
        ]);
    Route::resource('patient/departments', PatientDepartmentController::class)
        ->only(['index', 'show'])
        ->names([
            'index' => 'patient.departments.index',
            'show' => 'patient.departments.show',
        ]);
    Route::resource('patient/appointments', PatientAppointmentController::class)
        ->only(['index', 'create', 'store'])
        ->names([
            'index' => 'patient.appointments.index',
            'create' => 'patient.appointments.create',
            'store' => 'patient.appointments.store',
        ]);
    Route::patch(
        '/patient/appointments/{appointment}/cancel',
        [PatientAppointmentController::class, 'cancel']
    )->name('patient.appointments.cancel');
    Route::get('/patient/profile', [PatientProfileController::class, 'index'])
        ->name('patient.profile');
    Route::get('/patient/profile/edit', [PatientProfileController::class, 'edit'])
        ->name('patient.profile.edit');
    Route::patch('/patient/profile', [PatientProfileController::class, 'update'])
        ->name('patient.profile.update');

});
