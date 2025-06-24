<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GpsLocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WifiLocationController;
use App\Http\Controllers\ManualAttendanceRequestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Exports\UsersExport;
use App\Http\Controllers\DeviceLogController;
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
    Route::get('/attendance-logs', [AttendanceController::class, 'logs'])->name('attendance.logs');

    Route::prefix('wifi-attendance')->group(function () {
        Route::get('/', [WifiLocationController::class, 'index'])->name('index');
        Route::get('/create', [WifiLocationController::class, 'create'])->name('create');
        Route::post('/', [WifiLocationController::class, 'store'])->name('store');
    });

    // GPS Attendance
        Route::prefix('gps-attendance')->name('gps-attendance.')->group(function () {
            Route::get('/', [GpsLocationController::class, 'index'])->name('index');
            Route::get('/create', [GpsLocationController::class, 'create'])->name('create');
            Route::post('/', [GpsLocationController::class, 'store'])->name('store');
        });


    Route::get('/device-logs', [DeviceLogController::class, 'index'])->name('device.logs');

    Route::get('manual-attendance', [ManualAttendanceRequestController::class,'index'])->name('admin.manual.index');
    Route::put('manual-attendance/{manualAttendanceRequest}', [ManualAttendanceRequestController::class, 'update'])->name('admin.manual.update');

    Route::get('/users/export', function () {
        return Excel::download(new UsersExport, 'users.xlsx');
    })->name('users.export');

    Route::get('/reports', function () {
        return Inertia::render('Reports/Index');
    })->name('reports.index');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
