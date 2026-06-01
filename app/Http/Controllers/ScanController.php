<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientScan;
use App\Models\AppNotification;
use App\Models\AuditLog;
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

        AuditLog::create([
            'user_id' => session('user_id'),
            'action' => 'Uploaded scan',
            'target_type' => 'PatientScan',
            'target_id' => $scan->id,
            'description' => 'Uploaded a scan for patient ' . $patient->name,
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

        if (!$this->canDownloadScan()) {
            abort(403);
        }

        if (session('user_role') === 'patient' && $scan->patient_id != session('user_id')) {
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

        if (!$this->canDeleteScan()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($scan->file_path)) {
            Storage::disk('public')->delete($scan->file_path);
        }

        AuditLog::create([
            'user_id' => session('user_id'),
            'action' => 'Deleted scan',
            'target_type' => 'PatientScan',
            'target_id' => $scan->id,
            'description' => 'Deleted a scan record.',
        ]);

        $scan->delete();

        return back()->with('success', 'Scan deleted successfully.');
    }

    private function canDownloadScan()
    {
        return in_array(session('user_role'), [
            'admin',
            'doctor',
            'radiographer',
            'radiologist',
            'patient',
        ]);
    }

    private function canDeleteScan()
    {
        return in_array(session('user_role'), [
            'admin',
            'radiographer',
        ]);
    }
}