<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientReport;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $report = PatientReport::create([
            'patient_id' => $patient->id,
            'uploaded_by' => session('user_id'),
            'report_path' => $path,
            'status' => 'uploaded',
        ]);

        if ($patient->assigned_doctor_id) {
            AppNotification::create([
                'user_id' => $patient->assigned_doctor_id,
                'title' => 'New Report Uploaded',
                'message' => 'A new report has been uploaded for ' . $patient->name . '.',
                'type' => 'report_uploaded',
            ]);
        }

        return redirect()
            ->route('patients.show', $patient->id)
            ->with('success', 'Report uploaded successfully.');
    }
    
    public function download($id)
    {
        $report = PatientReport::findOrFail($id);

        if (!$this->canDownloadReport()) {
            abort(403);
        }
        
        if (session('user_role') === 'patient' && $report->patient_id != session('user_id')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($report->report_path)) {
            return back()->withErrors([
                'report' => 'Report file not found.',
            ]);
        }

        return Storage::disk('public')->download($report->report_path);
    }

    public function destroy($id)
    {
        $report = PatientReport::findOrFail($id);

        if (!$this->canDeleteReport()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($report->report_path)) {
            Storage::disk('public')->delete($report->report_path);
        }

        $report->delete();

        return back()->with('success', 'Report deleted successfully.');
    }

    private function canDownloadReport()
    {
        return in_array(session('user_role'), [
            'admin',
            'doctor',
            'radiologist',
            'patient',
        ]);
    }

    private function canDeleteReport()
    {
        return in_array(session('user_role'), [
            'admin',
            'radiologist',
        ]);
    }
}