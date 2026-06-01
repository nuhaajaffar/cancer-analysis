<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientScan;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $scan = PatientScan::create([
            'patient_id' => $patient->id,
            'uploaded_by' => session('user_id'),
            'file_path' => $path,
        ]);

        if ($patient->assigned_radiologist_id) {
            AppNotification::create([
                'user_id' => $patient->assigned_radiologist_id,
                'title' => 'New Scan Uploaded',
                'message' => 'A new scan has been uploaded for ' . $patient->name . '.',
                'type' => 'scan_uploaded',
            ]);
        }

        return redirect()
            ->route('patients.show', $patient->id)
            ->with('success', 'Scan uploaded successfully.');
    }
    
    public function download($id)
    {
        $scan = PatientScan::findOrFail($id);

        if (!in_array(session('user_role'), ['admin', 'doctor', 'radiographer', 'radiologist', 'patient'])) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($scan->file_path)) {
            return back()->withErrors([
                'scan' => 'Scan file not found.',
            ]);
        }

        return Storage::disk('public')->download($scan->file_path);
    }

    public function destroy($id)
    {
        $scan = PatientScan::findOrFail($id);

        if (!in_array(session('user_role'), ['admin', 'radiographer'])) {
            abort(403);
        }

        if (Storage::disk('public')->exists($scan->file_path)) {
            Storage::disk('public')->delete($scan->file_path);
        }

        $scan->delete();

        return back()->with('success', 'Scan deleted successfully.');
    }
}