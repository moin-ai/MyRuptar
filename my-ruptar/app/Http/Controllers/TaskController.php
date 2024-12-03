<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    

    
    // Fetch and display tasks
    public function index()
    {
        $tasks = Task::paginate(6); // 6 tasks
    return view('tasks.index', compact('tasks'));
    }

    // Store a new task
    public function store(Request $request)
    {
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

    // Edit task (fetch task data for editing)
    public function edit($id)
    {
        $task = Task::findOrFail($id); // Fetch task by ID or fail
        return response()->json($task); // Return task data as JSON for the frontend
    }

    // Update task
    public function update(Request $request, $id)
{
    // Validate input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'due_date' => 'required|date',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    

    // Find and update the task
    $task = Task::findOrFail($id);
    $task->name = $validatedData['name'];
    $task->description = $validatedData['description'];
    $task->due_date = $validatedData['due_date'];

    if ($request->hasFile('image')) {
        // Optional: Delete the old image
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        // Store the new image
        $task->image = $request->file('image')->store('task-images', 'public');
    }

    $task->save();

    return redirect()->back()->with('success', 'Task updated successfully!');
}


    // Delete task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Delete image if exists
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    
}
