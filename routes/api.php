<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('tasks', TaskController::class)
        ->only(['index', 'show']);

    Route::apiResource('tasks', TaskController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware('role:assignor');

    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->middleware('role:assignee');
});
