<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
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
    Route::post('/patients/import', [PatientController::class, 'import']);
    Route::delete('/patients/import/clear', [PatientController::class, 'clearImported']);
    Route::get('/patients/export', [PatientController::class, 'export']);
    Route::post('/medicines/import', [MedicineController::class, 'import']);
    Route::delete('/medicines/import/clear', [MedicineController::class, 'clearImported']);
    Route::get('/medicines/export', [MedicineController::class, 'export']);
    Route::get('/billing', [BillingController::class, 'index']);
    Route::get('/billing/create', [BillingController::class, 'create']);
    Route::post('/billing/preview', [BillingController::class, 'preview']);
    Route::get('/billing/export', [BillingController::class, 'export']);
    Route::get('/billing/{id}', [BillingController::class, 'show']);
    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::get('/doctors/create', [DoctorController::class, 'create']);
    Route::post('/doctors', [DoctorController::class, 'store']);
    Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit']);
    Route::put('/doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
