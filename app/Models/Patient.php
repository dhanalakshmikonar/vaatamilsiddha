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
        'visit_date',
        'diagnosis',
        'total_amount',
    ];

    public function patientMedicines()
    {
        return $this->hasMany(PatientMedicine::class);
    }
}
