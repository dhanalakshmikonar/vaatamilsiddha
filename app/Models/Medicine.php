<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'cost',
        'stock',
    ];

    public function patientMedicines()
    {
        return $this->hasMany(PatientMedicine::class);
    }
}
