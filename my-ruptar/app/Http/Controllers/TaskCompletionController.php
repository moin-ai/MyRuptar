<?php
namespace App\Http\Controllers;

use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskCompletionController extends Controller
{
    public function markComplete($taskId)
    {
        try {
            $assignment = TaskAssignment::where('task_id', $taskId)
                ->where('user_id', Auth::id())
                ->whereNull('completed_at')
                ->firstOrFail();

            $assignment->update([
                'completed_at' => now()
            ]);

            return redirect()->back()->with('success', 'Task marked as complete!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to mark task as complete.');
        }
    }
}
