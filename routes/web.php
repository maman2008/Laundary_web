<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeRequestController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminIzinController;
use App\Http\Controllers\Admin\AdminPayrollController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Karyawan routes
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/absen', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/absen', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('/absen/checkout', [AttendanceController::class, 'checkout'])->name('attendance.checkout');

    // Pengajuan karyawan
    Route::get('/pengajuan', [EmployeeRequestController::class, 'index'])->name('requests.index');
    Route::get('/pengajuan/buat', [EmployeeRequestController::class, 'create'])->name('requests.create');
    Route::post('/pengajuan', [EmployeeRequestController::class, 'store'])->name('requests.store');
    Route::get('/pengajuan/{id}/edit', [EmployeeRequestController::class, 'edit'])->name('requests.edit');
    Route::put('/pengajuan/{id}', [EmployeeRequestController::class, 'update'])->name('requests.update');
    Route::delete('/pengajuan/{id}', [EmployeeRequestController::class, 'destroy'])->name('requests.destroy');

    // Izin Tidak Masuk (terpisah dari pengajuan umum)
    Route::get('/izin-tidak-masuk', [IzinController::class, 'create'])->name('izin.create');
    Route::post('/izin-tidak-masuk', [IzinController::class, 'store'])->name('izin.store');

    // Gaji karyawan
    Route::get('/gaji', [PayrollController::class, 'index'])->name('payrolls.index');
});

// Admin routes (tanpa Filament)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/', function () { return redirect()->route('admin.dashboard'); });
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Absensi
    Route::get('/absensi', [AdminAttendanceController::class, 'index'])->name('attendance.index');

    // Pengajuan
    Route::get('/pengajuan', [AdminRequestController::class, 'index'])->name('requests.index');
    Route::post('/pengajuan/{id}/accept', [AdminRequestController::class, 'accept'])->name('requests.accept');
    Route::post('/pengajuan/{id}/reject', [AdminRequestController::class, 'reject'])->name('requests.reject');

    // Izin Tidak Masuk (khusus)
    Route::get('/izin-tidak-masuk', [AdminIzinController::class, 'index'])->name('izin.index');
    Route::post('/izin-tidak-masuk/{id}/accept', [AdminIzinController::class, 'accept'])->name('izin.accept');
    Route::post('/izin-tidak-masuk/{id}/reject', [AdminIzinController::class, 'reject'])->name('izin.reject');

    // Gaji
    Route::get('/gaji', [AdminPayrollController::class, 'index'])->name('payroll.index');
    Route::get('/gaji/buat', [AdminPayrollController::class, 'create'])->name('payroll.create');
    Route::post('/gaji', [AdminPayrollController::class, 'store'])->name('payroll.store');
    Route::post('/gaji/{id}/mark-paid', [AdminPayrollController::class, 'markPaid'])->name('payroll.markPaid');
    // Upload bukti & slip dihapus dari daftar; bukti diunggah saat membuat payroll
});

require __DIR__.'/auth.php';

