<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GpsLocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WifiLocationController;
use App\Http\Controllers\ManualAttendanceRequest;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::put('/{user}/status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
});
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('wifi', [WifiLocationController::class, 'index'])->name('admin.wifi.index');
    Route::get('wifi/create', [WifiLocationController::class, 'create'])->name('admin.wifi.create');
    Route::post('wifi', [WifiLocationController::class, 'store'])->name('admin.wifi.store');

    Route::get('gps', [GpsLocationController::class, 'index'])->name('admin.gps.index');
    Route::get('gps/create', [GpsLocationController::class, 'create'])->name('admin.gps.create');
    Route::post('gps', [GpsLocationController::class, 'store'])->name('admin.gps.store');

    Route::get('manual-attendance', [ManualAttendanceRequest::class,'index'])->name('admin.manual.index');
    Route::put('manual-attendance/{manualAttendanceRequest}', [ManualAttendanceRequest::class, 'update'])->name('admin.manual.update');

    Route::get('/users/export', function () {
    return Excel::download(new UsersExport, 'users.xlsx');
})->name('users.export');
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
