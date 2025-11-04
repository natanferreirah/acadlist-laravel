<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

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

        $teacher = Teacher::create($request->except('subjects'));

        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        return redirect()->route('teachers.index')->with('success', 'Professor cadastrado com sucesso!');
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
