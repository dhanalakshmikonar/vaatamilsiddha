<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorCertificate extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'diagnosis',
        'date',
        'leave_from',
        'leave_to',
        'certificate_type',
        'doctor_description',
    ];

    protected $casts = [
        'date' => 'date',
        'leave_from' => 'date',
        'leave_to' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
