<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Common dashboard for all users
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management (accessible by all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for wardens
    Route::middleware(['role:warden'])->group(function () {
        Route::resource('tasks', TaskController::class); // Full CRUD for tasks
        Route::get('/students', [StudentController::class, 'index'])->name('students.index'); // Manage students
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy'); // Delete students
    });

    // Routes for students
    Route::middleware(['role:student'])->group(function () {
        Route::get('/tasks/student', [TaskController::class, 'studentView'])->name('tasks.studentView'); // View assigned tasks
        Route::post('/tasks/{task}/complete', [TaskController::class, 'markComplete'])->name('tasks.complete'); // Mark tasks as complete
    });
});

require __DIR__.'/auth.php';
