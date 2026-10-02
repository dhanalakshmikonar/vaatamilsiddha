<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\IncomeController;
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
        $doctors = \App\Models\Doctor::count();
        $appointments = \App\Models\Appointment::count();
        $certificates = \App\Models\DoctorCertificate::count();
        $todayDate = now()->toDateString();
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();
        $todayIncome = (float) Patient::whereDate('visit_date', $todayDate)->sum('total_amount');
        $todayIncomePatients = Patient::whereDate('visit_date', $todayDate)->count();
        $monthIncome = (float) Patient::whereBetween('visit_date', [$monthStart, $monthEnd])->sum('total_amount');
        $monthIncomePatients = Patient::whereBetween('visit_date', [$monthStart, $monthEnd])->count();

        $recentAppointments = \App\Models\Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->take(5)
            ->get();

        $recentPatients = Patient::latest()->take(5)->get();

        return view('dashboard', compact(
            'patients',
            'medicines',
            'availableStock',
            'doctors',
            'appointments',
            'certificates',
            'todayIncome',
            'todayIncomePatients',
            'monthIncome',
            'monthIncomePatients',
            'recentAppointments',
            'recentPatients',
        ));
    });



    Route::post('/patients/import', [PatientController::class, 'import']);
    Route::delete('/patients/import/clear', [PatientController::class, 'clearImported']);
    Route::get('/patients/export', [PatientController::class, 'export']);
    Route::resource('patients', PatientController::class);

    Route::post('/medicines/import', [MedicineController::class, 'import']);
    Route::delete('/medicines/import/clear', [MedicineController::class, 'clearImported']);
    Route::get('/medicines/export', [MedicineController::class, 'export']);
    Route::resource('medicines', MedicineController::class);

    Route::get('/billing', [BillingController::class, 'index']);
    Route::get('/income/daily', [IncomeController::class, 'daily']);
    Route::get('/income/monthly', [IncomeController::class, 'monthly']);
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

    Route::post('/appointments/{id}/attendance', [AppointmentController::class, 'markAttendance']);
    Route::resource('appointments', AppointmentController::class);

    Route::resource('certificates', \App\Http\Controllers\DoctorCertificateController::class);
    Route::get('/doctor-certifications', function () {
        return redirect('/certificates');
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

