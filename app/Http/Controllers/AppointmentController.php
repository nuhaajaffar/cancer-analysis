<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\AppNotification;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $status = request('status');

        $appointments = Appointment::with(['patient', 'staff'])
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        return view('appointments.index', compact('appointments', 'status'));
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

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'staff_id' => session('user_id'),
            'appointment_date' => $request->appointment_date,
            'purpose' => $request->purpose,
            'status' => 'scheduled',
        ]);

        AppNotification::create([
            'user_id' => $patient->id,
            'title' => 'New Appointment Scheduled',
            'message' => 'An appointment has been scheduled for you.',
            'type' => 'appointment',
        ]);

        return redirect()
            ->route('patients.show', $patient->id)
            ->with('success', 'Appointment created successfully.');
    }

    public function edit($id)
    {
        $appointment = Appointment::with(['patient', 'staff'])->findOrFail($id);

        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'purpose' => 'required|string|max:255',
            'status' => 'required|string|in:scheduled,completed,cancelled',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'purpose' => $request->purpose,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}