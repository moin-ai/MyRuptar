<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Fetch all students (users with 'student' role)
        $students = Student::students()->get(); // Applying the 'students' scope to filter by role
        return view('students.index', compact('students')); // Pass students to the view
    }

    public function destroy($id)
    {
        // Find the student by ID
        $student = Student::students()->find($id); // Apply 'students' scope here

        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        // Delete the student record
        $student->delete();

        // Redirect with a success message
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}

