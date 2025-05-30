<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseController extends Controller
{
 public function index(): JsonResponse
    {

        $dataCourse = Course::all();
        return response()->json($dataCourse, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $Student = Course::findOrFail($id);
            return response()->json($Student, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Course tidak ditemukan'], 404);
        }
    }

    // Menambahkan user baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'code' => 'required|string|max:255|unique:courses,code',
            'credits' => 'required|integer|min:2|max:9',
            'semester' => 'required|integer|max:16',
        ]);

        $Student = Course::create([
            'name' => $request->name,
            'code' => $request->code,
            'credits' => $request->credits,
            'semester' => $request->semester,
        ]);


        return response()->json([
            'message' => 'Data Course berhasil ditambahkan.',
            'data' => $Student
        ], 201);
    }

      // Mengupdate data user
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $Student = Course::findOrFail($id);
  
              $request->validate([
                'name' => 'sometimes|string|max:255|unique:courses,name',
                'code' => 'sometimes|string|max:255|unique:courses,code',
                'credits' => 'sometimes|integer|min:2|max:9',
                'semester' => 'sometimes|integer|max:16',
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['name', 'code', 'credits','semester']);

              $Student->update($data);
              
  
              return response()->json([
                  'message' => $Student->wasChanged()
                      ? 'Data Course berhasil diupdate.'
                      : 'Tidak ada perubahan pada data Course.',
                  'data' => $Student
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Course tidak ditemukan'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $Student = Course::findOrFail($id);
              $Student->delete();
  
              return response()->json(['message' => 'Data Course berhasil dihapus.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Course tidak ditemukan.'], 404);
          }
      }
}
