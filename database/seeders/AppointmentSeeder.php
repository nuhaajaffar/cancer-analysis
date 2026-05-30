<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patient = User::where('email', 'patient1@example.com')->first();
        $doctor = User::where('email', 'doctor@example.com')->first();

        Appointment::create([
            'patient_id' => $patient->id,
            'staff_id' => $doctor->id,
            'appointment_date' => now()->addDays(3),
            'purpose' => 'Follow-up consultation',
            'status' => 'scheduled',
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'staff_id' => $doctor->id,
            'appointment_date' => now()->subDays(2),
            'purpose' => 'Review AI-generated report',
            'status' => 'completed',
        ]);
    }
}
