<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [UserController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Dashboard Summary
        Route::get('/dashboard', [UserController::class, 'dashboard']);

        // GPS Attendance
        Route::post('/attendance/check-in', [AttendanceController::class, 'gpsCheckIn']);

        // Wi-Fi Attendance
        Route::post('/attendance/wifi', [AttendanceController::class, 'wifiCheckIn']);

        // Manual Attendance
        Route::post('/attendance/manual', [AttendanceController::class, 'manualCheckIn']);

        // Attendance Reports

        Route::get('/report/today', [ReportController::class, 'today']);
        Route::get('/report/history', [ReportController::class, 'history']);
        Route::post('/report/filter', [ReportController::class, 'filter']);

    });
});
