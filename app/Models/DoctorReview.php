<?php

namespace App\Models;

use App\Models\User;
use App\Models\PatientReport;
use Illuminate\Database\Eloquent\Model;

class DoctorReview extends Model
{
    protected $fillable = [
        'patient_report_id',
        'doctor_id',
        'review',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function report()
    {
        return $this->belongsTo(PatientReport::class, 'patient_report_id');
    }
}