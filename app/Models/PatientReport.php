<?php

namespace App\Models;

use App\Models\User;
use App\Models\DoctorReview;
use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    protected $fillable = [
        'patient_id',
        'uploaded_by',
        'report_path',
        'status',
    ];

    public function reviews()
    {
        return $this->hasMany(DoctorReview::class, 'patient_report_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}