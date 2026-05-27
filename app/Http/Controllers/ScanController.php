<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientScan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function create($id)
    {
        $patient = User::findOrFail($id);

        return view('scans.create', compact('patient'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'scan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $patient = User::findOrFail($id);

        $path = $request->file('scan')->store(
            'scans',
            'public'
        );

        PatientScan::create([
            'patient_id' => $patient->id,
            'uploaded_by' => session('user_id'),
            'file_path' => $path,
        ]);

        return redirect()
            ->route('patients.show', $patient->id)
            ->with('success', 'Scan uploaded successfully.');
    }
}