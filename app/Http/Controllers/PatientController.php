<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $patients = User::where('role', 'patient')->get();

        return view('patients.index', compact('patients'));
    }

    public function show($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $patient = User::with(['scans', 'reports.reviews.doctor'])->where('role', 'patient')->findOrFail($id);

        return view('patients.show', compact('patient'));
    }

    public function myRecords()
    {
        $patient = User::with([
                'scans',
                'reports.reviews.doctor',
                'patientAppointments.staff'
            ])
            ->findOrFail(session('user_id'));

        return view('patients.my-records', compact('patient'));
    }
}