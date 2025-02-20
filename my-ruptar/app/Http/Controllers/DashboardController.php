<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function wardenDashboard(Request $request)
    {
        // Basic Overview Statistics
        $overview = [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalTasks' => Task::count(),
            'completedTasks' => DB::table('task_assignments')
                ->whereNotNull('completed_at')
                ->count()
        ];

        // Student Performance
        $studentPerformance = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(task_assignments.id) as total_assigned'),
                DB::raw('COUNT(CASE WHEN task_assignments.completed_at IS NOT NULL THEN 1 END) as completed_tasks'),
                DB::raw('ROUND(COUNT(CASE WHEN task_assignments.completed_at IS NOT NULL THEN 1 END) * 100.0 / NULLIF(COUNT(task_assignments.id), 0), 2) as completion_rate')
            )
            ->where('users.role', 'student')
            ->leftJoin('task_assignments', 'users.id', '=', 'task_assignments.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('completion_rate')
            ->get();

        // Task Completion Trends
        $completionTrends = $this->getCompletionTrends();

        // New reporting features
        $tasks = Task::with(['assignments.user'])->get();
        $students = User::where('role', 'student')->get();

        // Selected student details
        $selectedStudent = null;
        $studentTasks = [];
        $studentStats = [];
        if ($request->has('student_id')) {
            $selectedStudent = User::findOrFail($request->student_id);
            
            $studentStats = DB::table('task_assignments')
                ->where('user_id', $selectedStudent->id)
                ->selectRaw('COUNT(*) as total_assigned, 
                            SUM(CASE WHEN completed_at IS NOT NULL THEN 1 ELSE 0 END) as completed')
                ->first();

            $studentTasks = DB::table('task_assignments')
                ->where('user_id', $selectedStudent->id)
                ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
                ->select('tasks.id', 'tasks.name', 'task_assignments.assigned_at', 'task_assignments.completed_at')
                ->get();
        }

        return view('dashboard', compact(
            'overview', 
            'studentPerformance', 
            'completionTrends',
            'tasks',
            'students',
            'selectedStudent',
            'studentTasks',
            'studentStats'
        ));
    }

    private function getCompletionTrends()
    {
        $trends = [];
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trends[$date->format('Y-m-d')] = DB::table('task_assignments')
                ->whereDate('completed_at', $date)
                ->count();
        }
        return $trends;
    }
}