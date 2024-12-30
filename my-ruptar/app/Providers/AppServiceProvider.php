<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('view-tasks', function ($user) {
            return $user->role === 'warden'; // Allow only wardens to view tasks
        });
    
        Gate::define('create-task', function ($user) {
            return $user->role === 'warden'; // Allow only wardens to create tasks
        });
    
        Gate::define('edit-task', function ($user) {
            return $user->role === 'warden'; // Allow only wardens to edit tasks
        });
    
        Gate::define('update-task', function ($user) {
            return $user->role === 'warden'; // Allow only wardens to update tasks
        });
    
        Gate::define('delete-task', function ($user) {
            return $user->role === 'warden'; // Allow only wardens to delete tasks
        });
    }
}
