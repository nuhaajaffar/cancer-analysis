<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientScan extends Model
{
    protected $fillable = [
        'patient_id',
        'uploaded_by',
        'file_path',
    ];
}