<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentModel as Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //por num de pagina e deixar o user escolher num de paginas
        $perPage = $request->query('per_page', 10); // padrão 10
        // $student = Student::all();
        $students = Student::paginate($perPage);

        // retorna directo tudo criado
        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string",
            "email" => "required|unique:students,email", // unique:tabela,campo => significa que email deve unico na tabela student
            "gender" => "required|in:male,female," // Significa: o campo gender só pode ter um desses valores
        ]);

        // cria algo no banco de dados
        Student::create($data);

        return response()->json([
            "status" => true,
            "message" => "Created successfuly!"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        // tao simples como beber agua
        return response()->json([
            "status" => true,
            "message" => "Student found!",
            "data" => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            "name" => "sometimes|string", // sometimes significa so valida quando comecar a digitar algo novo
            "email" => "sometimes|unique:students,email," . $student->id, // unique:tabela,campo => significa que email deve unico na tabela student
            "gender" => "sometimes|in:male,female," // Significa: o campo gender só pode ter um desses valores
        ]);

        $student->update($data);

        return response()->json([
            "status" => true,
            "message" => "Updated successfuly!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            "status" => true,
            "message" => "Student deleted successfuly!"
        ]);
    }
}
