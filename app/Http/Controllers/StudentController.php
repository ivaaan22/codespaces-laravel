<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json(['students' => $students], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'edad'   => 'required|integer|min:1|max:120',
            'nota'   => 'required|numeric|min:0|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $student = Student::create($request->all());
        return response()->json(['student' => $student], 201);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        return response()->json(['student' => $student], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'edad'   => 'required|integer|min:1|max:120',
            'nota'   => 'required|numeric|min:0|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $student->update($request->all());
        return response()->json(['student' => $student], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|max:255',
            'edad'   => 'sometimes|integer|min:1|max:120',
            'nota'   => 'sometimes|numeric|min:0|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $student->update($request->all());
        return response()->json(['student' => $student], 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $student->delete();
        return response()->json(['message' => 'Estudiante eliminado'], 200);
    }
}