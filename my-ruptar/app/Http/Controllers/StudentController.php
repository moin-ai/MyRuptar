<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::students();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('student_id', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        $students = $query->get();
        return view('students.index', compact('students'));
    }

    public function destroy($id)
    {
        try {
            // Start transaction
            DB::beginTransaction();
            
            // Delete task assignments first
            DB::table('task_assignments')
                ->where('user_id', $id)
                ->delete();
            
            // Delete the student
            User::where('id', $id)
                ->where('role', 'student')
                ->delete();
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('students.index')
                ->with('success', 'Student deleted successfully');
                
        } catch (\Exception $e) {
            // Rollback transaction if anything fails
            DB::rollBack();
            
            // Log the error for debugging
            \Log::error('Student deletion failed: ' . $e->getMessage());
            
            return redirect()->route('students.index')
                ->with('error', 'Failed to delete student. Please try again.');
        }
    }
}
