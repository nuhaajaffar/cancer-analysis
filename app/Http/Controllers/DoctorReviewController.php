<?php

namespace App\Http\Controllers;

use App\Models\PatientReport;
use App\Models\DoctorReview;
use Illuminate\Http\Request;

class DoctorReviewController extends Controller
{
    public function create($reportId)
    {
        $report = PatientReport::findOrFail($reportId);

        return view('doctor-reviews.create', compact('report'));
    }

    public function store(Request $request, $reportId)
    {
        $request->validate([
            'review' => 'required|string|min:5',
        ]);

        $report = PatientReport::findOrFail($reportId);

        DoctorReview::create([
            'patient_report_id' => $report->id,
            'doctor_id' => session('user_id'),
            'review' => $request->review,
        ]);

        $report->update([
            'status' => 'reviewed',
        ]);

        return redirect()
            ->route('patients.show', $report->patient_id)
            ->with('success', 'Doctor review added successfully.');
    }
}