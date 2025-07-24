<?php
namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EnrollmentController extends Controller
{
    // Get all Enrollment with authors
    public function index(): JsonResponse
    {

        $dataEnrollment = Enrollment::with(['course','student'])->get();
        return response()->json($dataEnrollment, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            return response()->json($enrollment, 200);
        } catch (ModelNotFoundException $enrollment) {
            return response()->json(['message' => 'Enrollment Not Found'], 404);
        }
    }

    // Menambahkan enrollment baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255',
            'course_id' => 'required|string|max:255',
            'grade' => 'required|string',
            'attendance' => 'required|string',
            'status' => 'required|string'
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'grade' => $request->grade,
            'attendance' => $request ->attendance,
            'status' => $request ->status,
        ]);


        return response()->json([
            'message' => 'The Enrollment Has Been Added Successfully.',
            'data' => $enrollment
        ], 201);
    }

      // Mengupdate data enrollment
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $enrollment = Enrollment::findOrFail($id);
  
              $request->validate([
                'student_id' => 'sometimes|string|max:255',
                'course_id' => 'sometimes|string|max:255',
                'grade' => 'sometimes|string',
                'attendance' => 'sometimes|string',
                'status' => 'sometimes|string'
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['student_id', 'course_id', 'grade', 'attendance','status']);

              $enrollment->update($data);
              
  
              return response()->json([
                  'message' => $enrollment->wasChanged()
                      ? 'Enrollment Successfully Updated.'
                      : 'No Changes to Enrollment Data.',
                  'data' => $enrollment
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Enrollment Not Found'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $enrollment = Enrollment::findOrFail($id);
              $enrollment->delete();
  
              return response()->json(['message' => 'The Enrollment Has Been Successfully Deleted.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Enrollment Not Found.'], 404);
          }
      }
}
