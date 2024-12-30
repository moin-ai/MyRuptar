<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // Fetch and display tasks with search
    public function index(Request $request)
    {
        $query = Task::query();
        
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $tasks = $query->orderBy('due_date', 'asc')->paginate(6);
        return view('tasks.index', compact('tasks'));
    }

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

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
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

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
}
