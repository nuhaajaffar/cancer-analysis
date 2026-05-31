<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientScan;
use App\Models\PatientReport;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $role = session('user_role');
        $userId = session('user_id');

        $patientQuery = User::where('role', 'patient');

        if ($role === 'doctor') {
            $patientQuery->where('assigned_doctor_id', $userId);
        }

        if ($role === 'radiographer') {
            $patientQuery->where('assigned_radiographer_id', $userId);
        }

        if ($role === 'radiologist') {
            $patientQuery->where('assigned_radiologist_id', $userId);
        }

        $visiblePatientIds = $patientQuery->pluck('id');

        $stats = [
            'totalPatients' => $visiblePatientIds->count(),
            'totalScans' => PatientScan::whereIn('patient_id', $visiblePatientIds)->count(),
            'totalReports' => PatientReport::whereIn('patient_id', $visiblePatientIds)->count(),
            'totalAppointments' => Appointment::whereIn('patient_id', $visiblePatientIds)->count(),
            'pendingAI' => PatientScan::whereIn('patient_id', $visiblePatientIds)->where('ai_status', 'pending')->count(),
            'completedAI' => PatientScan::whereIn('patient_id', $visiblePatientIds)->where('ai_status', 'completed')->count(),
            'failedAI' => PatientScan::whereIn('patient_id', $visiblePatientIds)->where('ai_status', 'failed')->count(),
        ];

        if ($role === 'patient') {
            $patientId = session('user_id');

            $stats = [
                'myScans' => PatientScan::where('patient_id', $patientId)->count(),
                'myReports' => PatientReport::where('patient_id', $patientId)->count(),
                'myAppointments' => Appointment::where('patient_id', $patientId)->count(),
            ];
        }

        return match ($role) {
            'admin' => view('dashboard.admin', compact('stats')),
            'doctor' => view('dashboard.doctor', compact('stats')),
            'radiographer' => view('dashboard.radiographer', compact('stats')),
            'radiologist' => view('dashboard.radiologist', compact('stats')),
            'patient' => view('dashboard.patient', compact('stats')),
            default => redirect()->route('login'),
        };
    }
}