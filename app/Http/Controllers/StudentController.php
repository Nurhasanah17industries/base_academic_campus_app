<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{
   public function index(): JsonResponse
    {

        $dataStudent = Student::all();
        return response()->json($dataStudent, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $Student = Student::findOrFail($id);
            return response()->json($Student, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Akun Student tidak ditemukan'], 404);
        }
    }

    // Menambahkan user baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:student,email',
            'NIM' => 'required|integer|unique:student,NIM',
            'major' => 'required|string|max:255',
            'enlorment_year' => 'required|integer|min:1945|max:9999',
        ]);

        $Student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'NIM' => $request->NIM,
            'major' => $request->major,
            'enlorment_year' => $request->enlorment_year,
        ]);


        return response()->json([
            'message' => 'Akun Student berhasil ditambahkan.',
            'data' => $Student
        ], 201);
    }

      // Mengupdate data user
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $Student = Student::findOrFail($id);
  
              $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|max:255|unique:student,email',
                'NIM' => 'sometimes|integer|max:255|unique:student,NIM',
                'major' => 'sometimes|string|max:255',
                'enlorment_year' => 'sometimes|integer|string|min:1945|max:9999',
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['name', 'email', 'NIM','major','enlorment_year']);

              $Student->update($data);
              
  
              return response()->json([
                  'message' => $Student->wasChanged()
                      ? 'Akun Student berhasil diupdate.'
                      : 'Tidak ada perubahan pada data Student.',
                  'data' => $Student
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Akun Student tidak ditemukan'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $Student = Student::findOrFail($id);
              $Student->delete();
  
              return response()->json(['message' => 'Akun Student berhasil dihapus.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Akun Student tidak ditemukan.'], 404);
          }
      }
}
