<?php

use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'allUsers']);
    Route::post('/admin/create-user', [AdminController::class, 'createUser']);
});
