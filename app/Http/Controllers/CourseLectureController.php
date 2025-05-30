<?php

namespace App\Http\Controllers;

use App\Models\CourseLecture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseLectureController extends Controller
{
 public function index(): JsonResponse
    {

        $dataCourseLecture = CourseLecture::all();
        return response()->json($dataCourseLecture, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $Student = CourseLecture::findOrFail($id);
            return response()->json($Student, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Course Lecture tidak ditemukan'], 404);
        }
    }

    // Menambahkan user baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'course_id' => 'required|string|max:255',
            'lecturer_id' => 'required|string|max:255',
            'role' => 'required|string',
        ]);

        $Student = CourseLecture::create([
            'course_id' => $request->course_id,
            'lecturer_id' => $request->lecturer_id,
            'role' => $request->role
        ]);


        return response()->json([
            'message' => 'Data Course Lecturer berhasil ditambahkan.',
            'data' => $Student
        ], 201);
    }

      // Mengupdate data user
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $Student = CourseLecture::findOrFail($id);
  
              $request->validate([
                'course_id' => 'sometimes|string|max:255',
                'lecturer_id' => 'sometimes|string|max:255',
                'role' => 'sometimes|string',
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['course_id', 'lecturer_id', 'role']);

              $Student->update($data);
              
  
              return response()->json([
                  'message' => $Student->wasChanged()
                      ? 'Data Course Lecture berhasil diupdate.'
                      : 'Tidak ada perubahan pada data Course Lecture .',
                  'data' => $Student
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Course Lecture tidak ditemukan'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $Student = CourseLecture::findOrFail($id);
              $Student->delete();
  
              return response()->json(['message' => 'Data Course Lecture berhasil dihapus.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Course Lecture tidak ditemukan.'], 404);
          }
      }
}
