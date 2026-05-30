<?php

namespace Database\Seeders;

use App\Models\PatientReport;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientReportSeeder extends Seeder
{
    public function run(): void
    {
        $patient = User::where('email', 'patient1@example.com')->first();
        $radiologist = User::where('email', 'radiologist@example.com')->first();

        PatientReport::create([
            'patient_id' => $patient->id,
            'uploaded_by' => $radiologist->id,
            'report_path' => 'reports/demo-report.pdf', // only creates db record, not real pdf yet
            'status' => 'uploaded',
        ]);
    }
}
