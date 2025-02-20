<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\NewTaskNotification;

class TaskController extends Controller
{


   
    public function create()
    {
        $students = User::where('role', 'student')->get(); // Fetch all students
        return view('tasks.create', compact('students')); // Pass students to the view
    }
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
        
        // Fetch all students
        $students = User::where('role', 'student')->get();
    
        // Pass both tasks and students to the view
        return view('tasks.index', compact('tasks', 'students'));

        $tasks = $query->with('assignedStudents')->orderBy('due_date', 'asc')->paginate(6);

        // Fetch all students for selection in task creation form
        $students = User::where('role', 'student')->get();

        // Pass both tasks and students to the view
        return view('tasks.index', compact('tasks', 'students'));

        $query = Task::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

         $tasks = Task::with('assignedStudents')->orderBy('due_date', 'asc')->paginate(6);
    
        // Fetch all students
        $students = User::where('role', 'student')->get();

        // Pass both tasks and students to the view
        return view('tasks.index', compact('tasks', 'students'));
    }
    
    public function show($id)
    {
        $task = Task::with('assigned_students')->findOrFail($id);

        return response()->json($task);
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
{
    Gate::authorize('create-task');

    try {
        DB::beginTransaction();

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'selected_students' => 'nullable|array',
            'selected_students.*' => 'exists:users,id',
        ]);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        // Create task
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'attachment' => $attachmentPath,
        ]);

        // Assign task to students
        if ($request->has('massAssign')) {
            // Assign to all students
            $students = User::where('role', 'student')->get();
            foreach ($students as $student) {
                DB::table('task_assignments')->insert([
                    'task_id' => $task->id,
                    'user_id' => $student->id,
                    'assigned_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $student->notify(new NewTaskNotification($task));
            }
        } else {
            // Assign to selected students
            if ($request->filled('selected_students')) {
                foreach ($request->selected_students as $studentId) {
                    DB::table('task_assignments')->insert([
                        'task_id' => $task->id,
                        'user_id' => $studentId,
                        'assigned_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $selectedStudents = User::whereIn('id', $request->selected_students)->get();
                    foreach ($selectedStudents as $student) {
                        $student->notify(new NewTaskNotification($task));
                    }
                }
            }
        }

        DB::commit();
        return redirect()->back()->with('success', 'Task created and assigned successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to create task. Please try again.');
    }
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
