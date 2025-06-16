<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnValueMap;

class StudentController extends Controller
{
    public function index() {
        $students = Student::latest()->get();
        return response()->json($students, 200);
    }

    public function store(Request $request) {
        $validator = Validator::makae($request->all(), [
            'nim' => 'required|unique:students,nim',
            'name' => 'required|string|max:255',
            'born_date' => 'required|date',
            'gender' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json($validator->erros(), 422);
        }
        $students = Student::create($request->all());
        return response()->json([
            'message' => 'Data siswa berhasil ditambahkan',
            'data' => $students
        ], 201);
    }

    public function show(Student $students) {
        return response()->json($students, 200);
    }

    public function update(Request $request, Student $student) {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|unique:students,nim'.$student->id,
            'name' => 'required|string|max:255',
            'born_date' => 'required|date',
            'gender' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $student->update($request->all());
        return response()->json([
            'message' => 'Data siswa berhasil diperbarui',
            'data' => $student
        ], 200);
    }

    public function destroy(Student $student) {
        $student->delete();
        return response()->json(['message' => 'Data siswa berhasil dihapus'], 200);
    }
}
