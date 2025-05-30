<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EnrollmentController extends Controller
{
 public function index(): JsonResponse
    {

        $dataEnrollment = Enrollment::all();
        return response()->json($dataEnrollment, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $Student = Enrollment::findOrFail($id);
            return response()->json($Student, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Enrollment tidak ditemukan'], 404);
        }
    }

    // Menambahkan user baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|string|max:255',
            'course_id' => 'required|string|max:255',
            'grade' => 'required|string',
            'attendence' => 'required|string',
            'status' => 'required|string',
        ]);

        $Student = Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'grade' => $request->grade,
            'attendence' => $request->attendence,
            'status' => $request->status

        ]);


        return response()->json([
            'message' => 'Data Enrollment berhasil ditambahkan.',
            'data' => $Student
        ], 201);
    }

      // Mengupdate data user
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $Student = Enrollment::findOrFail($id);
  
              $request->validate([
                'student_id' => 'sometimes|string|max:255',
                'course_id' => 'sometimes|string|max:255',
                'grade' => 'sometimes|string',
                'attendence' => 'sometimes|string',
                'status' => 'sometimes|string',                
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['student_id', 'course_id', 'grade','attendence','status']);

              $Student->update($data);
              
  
              return response()->json([
                  'message' => $Student->wasChanged()
                      ? 'Data Enrolment berhasil diupdate.'
                      : 'Tidak ada perubahan pada data Enrolment.',
                  'data' => $Student
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Enrolment tidak ditemukan'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $Student = Enrollment::findOrFail($id);
              $Student->delete();
  
              return response()->json(['message' => 'Data Enrolment berhasil dihapus.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Enrolment tidak ditemukan.'], 404);
          }
      }
}
