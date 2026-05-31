<?php

namespace App\Http\Controllers;

use App\Models\PatientReport;
use App\Models\DoctorReview;
use App\Models\AppNotification;
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

        AppNotification::create([
            'user_id' => $report->patient_id,
            'title' => 'Doctor Review Added',
            'message' => 'A doctor has added a review to your report.',
            'type' => 'doctor_review',
        ]);

        $report->update([
            'status' => 'reviewed',
        ]);

        return redirect()
            ->route('patients.show', $report->patient_id)
            ->with('success', 'Doctor review added successfully.');
    }
}