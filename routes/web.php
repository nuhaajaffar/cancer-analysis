<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DoctorReviewController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::middleware(['role:admin,doctor,radiographer,radiologist'])->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])
        ->name('patients.index');

    Route::get('/patients/{id}', [PatientController::class, 'show'])
        ->name('patients.show');

    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('appointments.index');

    Route::get('/patients/{id}/appointments/create', [AppointmentController::class, 'create'])
        ->name('appointments.create');

    Route::post('/patients/{id}/appointments', [AppointmentController::class, 'store'])
        ->name('appointments.store');

    Route::post('/scans/{scanId}/analyse', [AIController::class, 'analyse'])
        ->name('scans.analyse');
});

Route::middleware(['role:radiographer'])->group(function () {
    Route::get('/patients/{id}/upload-scan', [ScanController::class, 'create'])
        ->name('scans.create');

    Route::post('/patients/{id}/upload-scan', [ScanController::class, 'store'])
        ->name('scans.store');
});

Route::middleware(['role:radiologist'])->group(function () {
    Route::get('/patients/{id}/upload-report', [ReportController::class, 'create'])
        ->name('reports.create');

    Route::post('/patients/{id}/upload-report', [ReportController::class, 'store'])
        ->name('reports.store');
});

Route::middleware(['role:doctor'])->group(function () {
    Route::get('/reports/{reportId}/review', [DoctorReviewController::class, 'create'])
        ->name('doctor-reviews.create');

    Route::post('/reports/{reportId}/review', [DoctorReviewController::class, 'store'])
        ->name('doctor-reviews.store');
});

Route::middleware(['role:patient'])->group(function () {
    Route::get('/my-records', [PatientController::class, 'myRecords'])
        ->name('patients.my-records');
});