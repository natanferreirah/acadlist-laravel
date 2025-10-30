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
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('teachers.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:teachers',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:teachers',
            'subjects' => 'array',
        ]);

        $teacher = Teacher::create($validated);
        $created = $teacher->subjects()->sync($request->subjects ?? []);

        if ($created) {
            return redirect()->route('teachers.index')->with('success', 'Professor cadastrado!');
        }
            return redirect()->back()->with('error', 'Erro ao cadastrar professor');
    }

    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:teachers,cpf,' . $teacher->id,
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'subjects' => 'array',
        ]);

        $teacher->update($validated);
        $updated = $teacher->subjects()->sync($request->subjects ?? []);

        if ($updated) {
            return redirect()->route('teachers.index')->with('success', 'Professor atualizado!');           
        }
            return redirect()->back()->with('error', 'Erro ao atualizar professor');
    }

    public function destroy(Teacher $teacher)
    {
        $deleted = $teacher->delete();

        if ($deleted) {
            return redirect()->route('teachers.index')->with('success', 'Professor excluído!');           
        }
            return redirect()->back()->with('error', 'Erro ao excluir professor');
    }
}
