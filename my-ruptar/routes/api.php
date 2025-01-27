<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MyRuptarAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Default Sanctum route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// MyRuptar API Routes - No authentication required for now
Route::prefix('v1')->group(function () {
    // List all students
    Route::get('/students', [MyRuptarAPIController::class, 'getAllStudents']);
    
    // List all tasks
    Route::get('/tasks', [MyRuptarAPIController::class, 'getAllTasks']);
    
    // Get student completion rate
    Route::get('/students/{studentId}/completion-rate', [MyRuptarAPIController::class, 'getStudentCompletionRate']);
});
