<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function wardenDashboard()
    {
        // Overview Statistics
        $overview = [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalTasks' => Task::count(),
            'completedTasks' => DB::table('task_assignments')->whereNotNull('completed_at')->count(),
            'overdueTasks' => DB::table('task_assignments')
                ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
                ->whereNull('completed_at')
                ->where('tasks.due_date', '<', now())
                ->count()
        ];

        // Task Metrics
        $taskMetrics = [
            'totalAssigned' => DB::table('task_assignments')->count(),
            'completed' => DB::table('task_assignments')->whereNotNull('completed_at')->count(),
            'pending' => DB::table('task_assignments')->whereNull('completed_at')->count(),
            'overdue' => DB::table('task_assignments')
                ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
                ->whereNull('completed_at')
                ->where('tasks.due_date', '<', now())
                ->count()
        ];

        // Student Performance
        $studentPerformance = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(task_assignments.id) as total_assigned'),
                DB::raw('COUNT(CASE WHEN task_assignments.completed_at IS NOT NULL THEN 1 END) as completed_tasks'),
                DB::raw('COUNT(CASE WHEN task_assignments.completed_at IS NULL AND tasks.due_date < NOW() THEN 1 END) as overdue_tasks'),
                DB::raw('ROUND(COUNT(CASE WHEN task_assignments.completed_at IS NOT NULL THEN 1 END) * 100.0 / NULLIF(COUNT(task_assignments.id), 0), 2) as completion_rate')
            )
            ->where('users.role', 'student')
            ->leftJoin('task_assignments', 'users.id', '=', 'task_assignments.user_id')
            ->leftJoin('tasks', 'task_assignments.task_id', '=', 'tasks.id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('completion_rate')
            ->get();

        return view('dashboard', compact('overview', 'taskMetrics', 'studentPerformance'));
    }
}
