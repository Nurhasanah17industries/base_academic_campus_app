<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LectureController extends Controller
{

     public function index(): JsonResponse
    {

        $dataLecturer = Lecture::all();
        return response()->json($dataLecturer, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $Lecturer = Lecture::findOrFail($id);
            return response()->json($Lecturer, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Lecturer tidak ditemukan'], 404);
        }
    }

    // Menambahkan user baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'NIP' => 'required|integer|unique:lecture,NIP',
            'department' => 'required|string',
            'email' => 'required|string|unique:lecture,email',
        ]);

        $Student = Lecture::create([
            'name' => $request->name,
            'NIP' => $request->NIP,
            'department' => $request->department,
            'email' => $request->email,
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
              $Student = Lecture::findOrFail($id);
  
              $request->validate([
                'name' => 'sometimes|string|max:255|',
                'NIP' => 'sometimes|string|max:255|unique:lecture,NIP',
                'department' => 'sometimes|integer|min:2|max:9',
                'email' => 'sometimes|integer|max:16',
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['name', 'NIP', 'department','email']);

              $Student->update($data);
              
  
              return response()->json([
                  'message' => $Student->wasChanged()
                      ? 'Data Lecture berhasil diupdate.'
                      : 'Tidak ada perubahan pada data Lecture.',
                  'data' => $Student
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Lecture tidak ditemukan'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $Student = Lecture::findOrFail($id);
              $Student->delete();
  
              return response()->json(['message' => 'Data Lecture berhasil dihapus.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'Data Lecture tidak ditemukan.'], 404);
          }
      }

}
