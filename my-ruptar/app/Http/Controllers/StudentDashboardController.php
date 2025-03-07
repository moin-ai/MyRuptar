<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    
    // Get all tasks with their completion status
    $tasks = DB::table('tasks')
        ->join('task_assignments', 'tasks.id', '=', 'task_assignments.task_id')
        ->where('task_assignments.user_id', $user->id)
        ->select(
            'tasks.*',
            'task_assignments.id as assignment_id',
            'task_assignments.completed_at',
            DB::raw('CASE WHEN tasks.due_date < NOW() THEN 1 ELSE 0 END as is_overdue')
        )
        ->orderBy('due_date', 'asc')
        ->get();

    // Calculate task statistics
    $taskOverview = [
        'totalAssigned' => $tasks->count(),
        'completed' => $tasks->whereNotNull('completed_at')->count(),
        'pending' => $tasks->whereNull('completed_at')->count()
    ];

    $taskOverview['completionRate'] = $taskOverview['totalAssigned'] > 0 
        ? round(($taskOverview['completed'] / $taskOverview['totalAssigned']) * 100, 2) 
        : 0;

    return view('students.dashboard', compact('tasks', 'taskOverview'));
}
 
public function markComplete($assignmentId)
{
    try {
        DB::beginTransaction();

        $assignment = DB::table('task_assignments')
            ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
            ->where('task_assignments.id', $assignmentId)
            ->where('task_assignments.user_id', Auth::id())
            ->whereNull('task_assignments.completed_at')
            ->where('tasks.due_date', '>=', now())
            ->first();

        if (!$assignment) {
            throw new \Exception('Task cannot be marked as complete.');
        }

        DB::table('task_assignments')
            ->where('id', $assignmentId)
            ->update([
                'completed_at' => now(),
                'updated_at' => now()
            ]);

        DB::commit();
        return redirect()->back()->with('success', 'Task marked as complete!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Could not mark task as complete.');
    }
}

}
