    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\TaskController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\DashboardController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\StudentDashboardController;
    use App\Http\Controllers\TaskCompletionController;

    // Public route
    Route::get('/', function () {
        return view('welcome');
    });

    // Authenticated routes
    Route::middleware(['auth', 'verified'])->group(function () {
        // Role-based dashboard redirect
        Route::get('/dashboard', function () {
            if (auth()->user()->role === 'warden') {
                return redirect()->route('warden.dashboard');
            } elseif (auth()->user()->role === 'student') {
                return redirect()->route('student.dashboard');
            }
            abort(403, 'Unauthorized');
        })->name('dashboard');

        // Warden routes
        // Warden routes
Route::middleware(['role:warden'])->group(function () {
    Route::get('/dashboard/warden', [DashboardController::class, 'wardenDashboard'])->name('warden.dashboard');
    Route::resource('tasks', TaskController::class);
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
});

// Student routes
Route::middleware(['role:student'])->group(function () {
    Route::get('/students/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::post('/tasks/{assignmentId}/complete', [StudentDashboardController::class, 'markComplete'])->name('tasks.complete');
});


        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//         // Student routes
// Route::middleware(['auth', 'role:student'])->group(function () {
//     Route::get('/students/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
//     Route::get('/tasks/student', [TaskController::class, 'studentView'])->name('tasks.studentView');
//     Route::post('/tasks/{task}/complete', [TaskController::class, 'markComplete'])->name('tasks.complete');
// });
Route::post('/notifications/{id}/mark-as-read', function($id) {
    auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
    return back();
})->name('notifications.markAsRead');



    });

    require __DIR__.'/auth.php';
