<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyRuptarAPIController extends Controller
{
    // 1. List all students
    public function getAllStudents()
    {
        try {
            $students = User::where('role', 'student')
                ->select('id', 'name', 'email')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $students
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch students'
            ], 500);
        }
    }

    // 2. List all tasks
    public function getAllTasks()
    {
        try {
            $tasks = Task::select('id', 'name', 'description', 'due_date')
                ->orderBy('due_date', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $tasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch tasks'
            ], 500);
        }
    }

    // 3. Get student's task completion rate
    public function getStudentCompletionRate($studentId)
    {
        try {
            $student = User::findOrFail($studentId);
            
            $stats = DB::table('task_assignments')
                ->where('user_id', $studentId)
                ->select(
                    DB::raw('COUNT(*) as total_tasks'),
                    DB::raw('COUNT(CASE WHEN completed_at IS NOT NULL THEN 1 END) as completed_tasks')
                )
                ->first();

            $completionRate = $stats->total_tasks > 0 
                ? round(($stats->completed_tasks / $stats->total_tasks) * 100, 2)
                : 0;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'student_name' => $student->name,
                    'total_tasks' => $stats->total_tasks,
                    'completed_tasks' => $stats->completed_tasks,
                    'completion_rate' => $completionRate . '%'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch completion rate'
            ], 500);
        }
    }
}
