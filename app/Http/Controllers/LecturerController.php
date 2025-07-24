<?php
namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LecturerController extends Controller
{
    // Get all Lecturer with authors
    public function index(): JsonResponse
    {

        $dataLecturer = Lecturer::all();
        return response()->json($dataLecturer, 200);
    }

    public function show($id): JsonResponse
    {
        try {
            $lecturer = Lecturer::findOrFail($id);
            return response()->json($lecturer, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecturer Not Found'], 404);
        }
    }

    // Menambahkan Lecturer baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'NIP' => 'required|string|max:255',
            'department' => 'required|string',
            'email' => 'required|string'
        ]);

        $lecturer = Lecturer::create([
            'name' => $request->name,
            'NIP' => $request->NIP,
            'department' => $request->department,
            'email' => $request ->email
        ]);


        return response()->json([
            'message' => 'The Lecturer Has Been Added Successfully.',
            'data' => $lecturer
        ], 201);
    }

      // Mengupdate data Lecturer
      public function update(Request $request, $id): JsonResponse
      {
          try {
              $lecturer = Lecturer::findOrFail($id);
  
              $request->validate([
                'name' => 'sometimes|string|max:255',
                'NIP' => 'sometimes|string|max:255',
                'department' => 'sometimes|string',
                'email' => 'sometimes|string'
            ]);
  
              // Hanya update field yang dikirim
              $data = $request->only(['name', 'NIP', 'department', 'email']);

              $lecturer->update($data);
              
  
              return response()->json([
                  'message' => $lecturer->wasChanged()
                      ? 'lecturer Successfully Updated.'
                      : 'No Changes to lecturer Data.',
                  'data' => $lecturer
              ], 200);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'lecturer Not Found'], 404);
          }
      }
  
      public function destroy($id): JsonResponse
      {
          try {
              $lecturer = Lecturer::findOrFail($id);
              $lecturer->delete();
  
              return response()->json(['message' => 'The lecturer Has Been Successfully Deleted.']);
          } catch (ModelNotFoundException $e) {
              return response()->json(['message' => 'lecturer Not Found.'], 404);
          }
      }
}
