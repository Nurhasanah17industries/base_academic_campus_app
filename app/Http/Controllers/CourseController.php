<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseController extends Controller
{
    // Get all Course with authors
    public function index(): JsonResponse
    {

        $dataCourse = Course::all();
        return response()->json($dataCourse, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $course = Course::findOrFail($id);
            return response()->json($course, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Course Not Found'], 404);
        }
    }

    // Menambahkan Course baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'credits' => 'required|string',
            'semester' => 'required|string'
        ]);

        $course = Course::create([
            'name' => $request->name,
            'code' => $request->code,
            'credits' => $request->credits,
            'semester' => $request ->semester
        ]);


        return response()->json([
            'message' => 'The Course Has Been Added Successfully.',
            'data' => $course
        ], 201);
    }

      // Mengupdate data Course
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $course = Course::findOrFail($id);
  
              $request->validate([
                'name' => 'sometimes|string|max:255',
                'code' => 'sometimes|string|max:255',
                'credits' => 'sometimes|string',
                'semester' => 'sometimes|string'
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['name', 'code', 'credits', 'semester']);

              $course->update($data);
              
  
              return response()->json([
                  'message' => $course->wasChanged()
                      ? 'Course Successfully Updated.'
                      : 'No Changes to Course Data.',
                  'data' => $course
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Course Not Found'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $course = Course::findOrFail($id);
              $course->delete();
  
              return response()->json(['message' => 'The Course Has Been Successfully Deleted.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Course Not Found.'], 404);
          }
      }
}
