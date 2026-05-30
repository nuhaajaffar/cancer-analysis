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

        $stats = [
            'totalPatients' => User::where('role', 'patient')->count(),
            'totalScans' => PatientScan::count(),
            'totalReports' => PatientReport::count(),
            'totalAppointments' => Appointment::count(),
            'pendingAI' => PatientScan::where('ai_status', 'pending')->count(),
            'completedAI' => PatientScan::where('ai_status', 'completed')->count(),
            'failedAI' => PatientScan::where('ai_status', 'failed')->count(),
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