<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::firstOrCreate(
            ['name' => 'Uma Petchi'],
            [
                'aadhar' => '123456789012',
                'license_no' => 'SIDDHA-2024-001',
                'specialization' => 'Siddha Medicine & Pulse Diagnosis',
                'qualification' => 'BSMS, MD (Siddha)',
                'role' => 'Chief Siddha Physician',
                'phone' => '9876543210',
                'experience' => 12,
                'clinic_address' => 'Vaatamilsiddha Clinic, Main Branch',
                'signature' => 'uploads/doctors/doctor_signature.jpg',
            ]
        );
    }
}
