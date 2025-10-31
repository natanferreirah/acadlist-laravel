<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $turmas = SchoolClass::all();
        $turmaId = $request->input('turma');

        $subjects = Subject::with(['teachers' => function ($q) {
            $q->withPivot('school_class_id');
        }])->get();

        if ($turmaId) {
            $subjects = $subjects->filter(function ($subject) use ($turmaId) {
                return $subject->teachers->contains(function ($teacher) use ($turmaId) {
                    return $teacher->pivot->school_class_id == $turmaId;
                });
            });
        }

        return view('subjects.index', compact('subjects', 'turmas', 'turmaId'));
    }

    public function create()
    {
        $materiasPadrao = ['Matemática', 'Português', 'História', 'Geografia', 'Ciências', 'Inglês'];
        $teachers = Teacher::all();
        $turmas = SchoolClass::all();

        return view('subjects.create', compact('materiasPadrao', 'teachers', 'turmas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        $subject = Subject::firstOrCreate(['name' => $validated['name']]);

        $subject->teachers()->attach($validated['teacher_id'], [
            'school_class_id' => $validated['school_class_id']
        ]);

        return redirect()->route('subjects.index')->with('success', 'Matéria criada com sucesso!');
    }

    public function edit(Subject $subject)
    {
        $teachers = Teacher::all();
        $turmas = SchoolClass::all();

        return view('subjects.edit', compact('subject', 'teachers', 'turmas'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update(['name' => $validated['name']]);

        return redirect()->route('subjects.index')->with('success', 'Matéria atualizada!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Matéria excluída!');
    }
}
