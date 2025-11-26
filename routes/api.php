<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\AttendanceController;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Admin routes
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'allUsers']);
    Route::post('/admin/create-user', [AdminController::class, 'createUser']);
});

// Teacher routes
Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    Route::get('/teacher/attendance', [TeacherController::class, 'attendanceList']);
});

// Student / Employee routes
Route::middleware(['auth:sanctum', 'role:student,employee'])->group(function () {
    Route::post('/checkin', [AttendanceController::class, 'checkIn']);
});

// FCM token route
Route::middleware('auth:sanctum')->post('/save-fcm-token', function (\Illuminate\Http\Request $request) {
    $request->validate(['fcm_token' => 'required|string']);
    $user = $request->user();
    $user->fcm_token = $request->fcm_token;
    $user->save();

    return response()->json(['message' => 'Token saved']);
});
