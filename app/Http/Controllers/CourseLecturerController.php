<?php
namespace App\Http\Controllers;

use App\Models\CourseLecturer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseLecturerController extends Controller
{
    // Get all CourseLecturer with authors
    public function index(): JsonResponse
    {

        $dataCourseLecturer = CourseLecturer::all();
        return response()->json($dataCourseLecturer, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $courseLecturer = CourseLecturer::findOrFail($id);
            return response()->json($courseLecturer, 200);
        } catch (ModelNotFoundException $courseLecturer) {
            return response()->json(['message' => 'CourseLecturer Not Found'], 404);
        }
    }

    // Menambahkan CourseLecturer baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'course_id' => 'required|string|max:255',
            'lecturer_id' => 'required|string|max:255',
            'role' => 'required|string'
        ]);

        $courseLecturer = CourseLecturer::create([
            'course_id' => $request->course_id,
            'lecturer_id' => $request->lecturer_id,
            'role' => $request->role
        ]);


        return response()->json([
            'message' => 'The CourseLecturer Has Been Added Successfully.',
            'data' => $courseLecturer
        ], 201);
    }

      // Mengupdate data CourseLecturer
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $courseLecturer = CourseLecturer::findOrFail($id);
  
              $request->validate([
                'course_id' => 'sometimes|string|max:255',
                'lecturer_id' => 'sometimes|string|max:255',
                'role' => 'sometimes|string'
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['course_id', 'lecturer_id', 'role']);

              $courseLecturer->update($data);
              
  
              return response()->json([
                  'message' => $courseLecturer->wasChanged()
                      ? 'CourseLecturer Successfully Updated.'
                      : 'No Changes to CourseLecturer Data.',
                  'data' => $courseLecturer
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'CourseLecturer Not Found'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $courseLecturer = CourseLecturer::findOrFail($id);
              $courseLecturer->delete();
  
              return response()->json(['message' => 'The CourseLecturer Has Been Successfully Deleted.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'CourseLecturer Not Found.'], 404);
          }
      }
}
