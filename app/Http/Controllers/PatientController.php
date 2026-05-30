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

        $patient = User::with([
                'scans',
                'reports.reviews.doctor',
                'assignedDoctor',
                'assignedRadiographer',
                'assignedRadiologist',
            ])
            ->where('role', 'patient')
            ->findOrFail($id);

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

    public function edit($id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);

        $doctors = User::where('role', 'doctor')->get();
        $radiographers = User::where('role', 'radiographer')->get();
        $radiologists = User::where('role', 'radiologist')->get();

        return view('patients.edit', compact(
            'patient',
            'doctors',
            'radiographers',
            'radiologists'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'medical_notes' => 'nullable|string',
            'assigned_doctor_id' => 'nullable|exists:users,id',
            'assigned_radiographer_id' => 'nullable|exists:users,id',
            'assigned_radiologist_id' => 'nullable|exists:users,id',
        ]);

        $patient = User::where('role', 'patient')->findOrFail($id);

        $patient->update($request->only([
            'name',
            'email',
            'date_of_birth',
            'gender',
            'phone',
            'address',
            'medical_notes',
            'assigned_doctor_id',
            'assigned_radiographer_id',
            'assigned_radiologist_id',
        ]));

        return redirect()
            ->route('patients.show', $patient->id)
            ->with('success', 'Patient profile updated successfully.');
    }
}