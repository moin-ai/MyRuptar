<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{


   

    /**
     * Display a listing of tasks with optional search functionality.
     */
    public function index(Request $request)
    {
        // Authorize the action using a Gate
        Gate::authorize('view-tasks');

        $query = Task::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        $tasks = $query->orderBy('due_date', 'asc')->paginate(6);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
    {
        // Authorize the action using a Gate
        Gate::authorize('create-task');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $task = new Task();
        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'];
        $task->due_date = $validatedData['due_date'];

        if ($request->hasFile('image')) {
            $task->image = $request->file('image')->store('task-images', 'public');
        }

        $task->save();

        return redirect()->back()->with('success', 'Task created successfully!');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit($id)
    {
        // Authorize the action using a Gate
        Gate::authorize('edit-task');

        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, $id)
    {
        // Authorize the action using a Gate
        Gate::authorize('update-task');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $task = Task::findOrFail($id);
        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'];
        $task->due_date = $validatedData['due_date'];

        if ($request->hasFile('image')) {
            if ($task->image) {
                Storage::disk('public')->delete($task->image);
            }
            $task->image = $request->file('image')->store('task-images', 'public');
        }

        $task->save();

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy($id)
    {
        // Authorize the action using a Gate
        Gate::authorize('delete-task');

        $task = Task::findOrFail($id);

        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
}
