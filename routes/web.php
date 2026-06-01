<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DoctorReviewController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\NotificationController;
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

    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])
        ->name('appointments.edit');

    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])
        ->name('appointments.update');

    Route::patch('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');

    Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])
        ->name('patients.edit');

    Route::put('/patients/{id}', [PatientController::class, 'update'])
        ->name('patients.update');
        
    Route::get('/reports/{id}/download', [ReportController::class, 'download'])
        ->name('reports.download');

    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])
        ->name('reports.destroy');

    Route::get('/scans/{id}/download', [ScanController::class, 'download'])
        ->name('scans.download');

    Route::delete('/scans/{id}', [ScanController::class, 'destroy'])
        ->name('scans.destroy');
});

Route::middleware(['role:admin,doctor,radiographer,radiologist,patient'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
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