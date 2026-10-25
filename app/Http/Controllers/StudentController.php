<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Retrieve all students
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Student::all()
        ], 200);
    }

    // Create a new student with validation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string|max:255',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student record created successfully.',
            'data' => $student
        ], 201);
    }

    // Retrieve an individual student by ID
    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student record not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $student
        ], 200);
    }

    // Update an existing student record using PUT with validation
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student record not found.'
            ], 404);
        }

        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id,' . $id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'course' => 'required|string|max:255',
        ]);

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Student record updated successfully.',
            'data' => $student
        ], 200);
    }

    // Delete an existing student record
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student record not found.'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student record deleted successfully.'
        ], 200);
    }
}