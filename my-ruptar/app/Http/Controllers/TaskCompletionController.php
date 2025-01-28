<?php
namespace App\Http\Controllers;

use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskCompletionController extends Controller
{
    public function markComplete(Request $request, $taskId)
{
    try {
        // Validate input
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validate proof image
        ]);

        // Find the task assignment for the logged-in student and task ID
        $assignment = TaskAssignment::where('task_id', $taskId)
            ->where('user_id', Auth::id())
            ->whereNull('completed_at')
            ->firstOrFail();

        // Handle file upload for proof
        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        // Mark task as complete and save proof path
        $assignment->update([
            'completed_at' => now(),
            'proof' => $proofPath,
        ]);

        return redirect()->back()->with('success', 'Task marked as complete with proof!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Unable to mark task as complete. Please try again.');
    }
}

}
