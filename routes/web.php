<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $patients = Patient::count();
    $medicines = Medicine::count();
    $availableStock = Medicine::sum('stock');

    return view('dashboard', compact(
        'patients',
        'medicines',
        'availableStock',
    ));
});

Route::resource('patients', PatientController::class);
Route::resource('medicines', MedicineController::class);
Route::get('/doctors', [DoctorController::class, 'index']);
