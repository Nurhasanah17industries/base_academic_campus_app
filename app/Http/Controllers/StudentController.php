<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'NIM' => 'required|unique:students',
            'major' => 'required',
            'enrollment_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        $student = Student::create($validated);

        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'sometimes',
            'email' => 'sometimes|email|unique:students,email,' . $student->id,
            'NIM' => 'sometimes|unique:students,NIM,' . $student->id,
            'major' => 'sometimes',
            'enrollment_year' => 'sometimes|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        $student->update($validated);

        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}
