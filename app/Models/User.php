<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\PatientScan;
use App\Models\PatientReport;
use App\Models\Appointment;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'medical_notes',
        'assigned_doctor_id',
        'assigned_radiographer_id',
        'assigned_radiologist_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scans()
    {
        return $this->hasMany(PatientScan::class, 'patient_id');
    }

    public function reports()
    {
        return $this->hasMany(PatientReport::class, 'patient_id');
    }

    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function staffAppointments()
    {
        return $this->hasMany(Appointment::class, 'staff_id');
    }

    public function assignedDoctor()
    {
        return $this->belongsTo(User::class, 'assigned_doctor_id');
    }

    public function assignedRadiographer()
    {
        return $this->belongsTo(User::class, 'assigned_radiographer_id');
    }

    public function assignedRadiologist()
    {
        return $this->belongsTo(User::class, 'assigned_radiologist_id');
    }
}