<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('subjects')->get();
        $qualificationOptions = Teacher::$qualificationOptions;
        return view('teachers.index', compact('teachers', 'qualificationOptions'));
    }

    public function create()
    {
        $qualificationOptions = Teacher::$qualificationOptions;
        $subjects = Subject::all();
        return view('teachers.create', compact('qualificationOptions', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'cpf' => 'required|string|unique:teachers,cpf',
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|string',
            'qualification' => 'required|string',
            'subjects' => 'array'
        ]);

        // Cria o professor
        $teacher = Teacher::create($request->except('subjects'));

        // Vincula as matérias, se houver
        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        // Gera username automático (ex: joao123)
        $username = Str::slug(explode(' ', $teacher->name)[0]) . rand(100, 999);

        // Cria o usuário de login vinculado ao professor
        User::create([
            'username' => $username,
            'name_school' => $teacher->name,
            'email' => $teacher->email,
            'password' => Hash::make('prof123'), // senha padrão
            'role' => 'teacher',
        ]);

        return redirect()->route('teachers.index')
            ->with('success', "Professor cadastrado com sucesso! Acesso criado com usuário: $username e senha padrão: prof123");
    }

    public function edit(Teacher $teacher)
    {
        $qualificationOptions = Teacher::$qualificationOptions;
        $subjects = Subject::all();
        return view('teachers.edit', compact('teacher', 'qualificationOptions', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string',
            'cpf' => 'required|string|unique:teachers,cpf,' . $teacher->id,
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|string',
            'qualification' => 'required|string',
            'subjects' => 'array'
        ]);

        $teacher->update($request->except('subjects'));
        $teacher->subjects()->sync($request->subjects ?? []);

        return redirect()->route('teachers.index')->with('success', 'Professor atualizado com sucesso!');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Professor removido com sucesso!');
    }
}
