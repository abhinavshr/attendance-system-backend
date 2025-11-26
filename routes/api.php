<?php

use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TeacherController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'allUsers']);
    Route::post('/admin/create-user', [AdminController::class, 'createUser']);
});

Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    Route::get('/teacher/attendance', [TeacherController::class, 'attendanceList']);
});
