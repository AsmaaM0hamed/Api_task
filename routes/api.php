<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;





    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('tasks')->group(function () {

        Route::get('/', [TaskController::class, 'index']);


        Route::post('/create', [TaskController::class, 'create']);

        // عرض مهمة محددة
        // Route::get('/{task}', [TaskController::class, 'show']);

        // تحديث مهمة
        // Route::put('/{task}', [TaskController::class, 'update']);

        // حذف مهمة
        // Route::delete('/{task}', [TaskController::class, 'destroy']);

        // مسارات إضافية
        // تغيير حالة المهمة
        // Route::patch('/{task}/status', [TaskController::class, 'updateStatus']);

        // إسناد المهمة لمستخدم
        // Route::patch('/{task}/assign', [TaskController::class, 'assignTask']);

        // عرض المهام الفرعية
        // Route::get('/{task}/subtasks', [TaskController::class, 'subtasks']);
    });
});
