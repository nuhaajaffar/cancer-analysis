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

        $search = request('search');

        $patients = User::where('role', 'patient')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('patients.index', compact('patients', 'search'));
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