<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//auth routes

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


//tasks routes
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('tasks')->group(function () {

        Route::get('/', [TaskController::class, 'listTasks']);

        Route::get('/showOneTask/{id}', [TaskController::class, 'showOneTask']);

        Route::get('/showMyTasks', [TaskController::class, 'showMyTasks']);

        Route::post('/create', [TaskController::class, 'create']);

        Route::post('/update/{id}', [TaskController::class, 'update']);

        Route::post('/updateStatus/{id}', [TaskController::class, 'updateStatus']);

        Route::post('/updateAssignedTo/{id}', [TaskController::class, 'updateAssignedTo']);

        Route::delete('/delete/{id}', [TaskController::class, 'delete']);
    });
});
