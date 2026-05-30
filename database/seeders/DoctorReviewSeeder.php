<?php

namespace Database\Seeders;

use App\Models\DoctorReview;
use App\Models\PatientReport;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorReviewSeeder extends Seeder
{
    public function run(): void
    {
        $report = PatientReport::first();
        $doctor = User::where('email', 'doctor@example.com')->first();

        DoctorReview::create([
            'patient_report_id' => $report->id,
            'doctor_id' => $doctor->id,
            'review' => 'Demo review: patient report has been reviewed. Follow-up is recommended.',
        ]);
    }
}
