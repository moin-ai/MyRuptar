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
    // Role-based dashboards
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'warden') {
            return view('dashboard'); // Warden dashboard
        } elseif (auth()->user()->role === 'student') {
            return redirect()->route('students.dashboard'); // Redirect students to their dashboard
        }
        abort(403, 'Unauthorized'); // Handle unexpected roles
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
        // Student Dashboard
        Route::get('/students/dashboard', function () {
            return view('students.dashboard');
        })->name('students.dashboard');

        // View assigned tasks
        Route::get('/tasks/student', [TaskController::class, 'studentView'])->name('tasks.studentView');

        // Mark tasks as complete
        Route::post('/tasks/{task}/complete', [TaskController::class, 'markComplete'])->name('tasks.complete');
    });
});

require __DIR__ . '/auth.php';
