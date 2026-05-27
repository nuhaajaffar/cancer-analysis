<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create($id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);

        return view('reports.create', compact('patient'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'report' => 'required|file|mimes:pdf|max:5120',
        ]);

        $patient = User::where('role', 'patient')->findOrFail($id);

        $path = $request->file('report')->store(
            'reports',
            'public'
        );

        PatientReport::create([
            'patient_id' => $patient->id,
            'uploaded_by' => session('user_id'),
            'report_path' => $path,
            'status' => 'uploaded',
        ]);

        return redirect()
            ->route('patients.show', $patient->id)
            ->with('success', 'Report uploaded successfully.');
    }
}