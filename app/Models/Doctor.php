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
'phone',
'experience',
'clinic_address',
'photo'
];

}