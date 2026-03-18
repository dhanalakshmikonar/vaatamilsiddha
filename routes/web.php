<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DoctorController;   // <-- ADD THIS

use App\Models\Patient;
use App\Models\Medicine;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', function () {

    $patients = Patient::count();
    $medicines = Medicine::count();
    

    return view('dashboard', compact(
        'patients',
        'medicines',
    ));
});

// Patients Module
Route::resource('patients', PatientController::class);

// Medicines Module
Route::resource('medicines', MedicineController::class);

// Doctors Module
Route::get('/doctors',[DoctorController::class,'index']);