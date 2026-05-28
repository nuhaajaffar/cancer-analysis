<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'staff'])
            ->latest()
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    public function create($patientId)
    {
        $patient = User::where('role', 'patient')->findOrFail($patientId);

        return view('appointments.create', compact('patient'));
    }

    public function store(Request $request, $patientId)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'purpose' => 'required|string|max:255',
        ]);

        $patient = User::where('role', 'patient')->findOrFail($patientId);

        Appointment::create([
            'patient_id' => $patient->id,
            'staff_id' => session('user_id'),
            'appointment_date' => $request->appointment_date,
            'purpose' => $request->purpose,
            'status' => 'scheduled',
        ]);

        return redirect()
            ->route('patients.show', $patient->id)
            ->with('success', 'Appointment created successfully.');
    }
}