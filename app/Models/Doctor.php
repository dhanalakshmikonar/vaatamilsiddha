<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'aadhar',
        'license_no',
        'specialization',
        'qualification',
        'role',
        'phone',
        'experience',
        'clinic_address',
        'photo',
        'aadhar_photo',
        'signature',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function certificates()
    {
        return $this->hasMany(DoctorCertificate::class);
    }
}

