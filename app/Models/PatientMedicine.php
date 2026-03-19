<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedicine extends Model
{
    protected $fillable = [
        'patient_id',
        'medicine_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
