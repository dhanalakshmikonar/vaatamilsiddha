<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'age',
        'gender',
        'phone',
        'place',
        'entity',
        'payment_mode',
        'fees',
        'therapy',
        'appointment_amount',
        'patient_history',
        'no_patient_history',
        'visit_date',
        'diagnosis',
        'total_amount',
    ];

    protected $casts = [
        'patient_history' => 'array',
        'no_patient_history' => 'boolean',
    ];

    public function patientMedicines()
    {
        return $this->hasMany(PatientMedicine::class);
    }
}
