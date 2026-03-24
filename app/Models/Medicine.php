<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'mode_of_product',
        'pharmaceutical_name',
        'expiry_date',
        'cost_price',
        'selling_price',
        'total_amount',
        'cost',
        'stock',
    ];

    public function patientMedicines()
    {
        return $this->hasMany(PatientMedicine::class);
    }
}
