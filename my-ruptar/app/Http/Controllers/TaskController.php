<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Save the data to the database
        // (assuming you have a Task model and migration)
        $task = new \App\Models\Task();
        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'];
        $task->due_date = $validatedData['due_date'];

        if ($request->hasFile('image')) {
            $task->image = $request->file('image')->store('task-images', 'public');
        }

        $task->save();

        // Redirect or respond with success
        return redirect()->back()->with('success', 'Task created successfully!');
    }
}
