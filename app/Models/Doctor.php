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
    ];
}
