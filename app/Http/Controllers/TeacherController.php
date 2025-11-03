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
        $qualificationLabels = Teacher::$qualificationLabels;
        $defaultSubjects = Subject::defaultSubjects();
        return view('teachers.create', compact('defaultSubjects', 'qualificationLabels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:teachers',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:teachers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'qualification' => 'nullable|string|in:technical,licentiate,bachelor,postgraduate,master,doctorate',
            'status' => 'in:active,inactive,on_leave',
        ]);

        $teacher = Teacher::create($request->only([
            'name',
            'cpf',
            'birth_date',
            'email',
            'phone',
            'address',
            'hire_date',
            'qualification',
            'status'
        ]));

        $subjectName = $request->input('subject_name');
        if ($subjectName === 'new') {
            $subjectName = $request->input('new_subject_name');
        }

        if ($subjectName) {
            Subject::create([
                'name' => $subjectName,
                'code' => strtoupper(substr($subjectName, 0, 3)) . rand(100, 999),
                'teacher_id' => $teacher->id,
                'status' => 'active',
            ]);
        }

        return redirect()->route('teachers.index')->with('success', 'Professor cadastrado com sucesso!');
    }


    public function edit($id)
    {
        $qualificationLabels = Teacher::$qualificationLabels;
        $teacher = Teacher::with('subjects')->findOrFail($id);
        $defaultSubjects = Subject::defaultSubjects();
        return view('teachers.edit', compact('teacher', 'defaultSubjects', 'qualificationLabels'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:teachers,cpf,' . $teacher->id,
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'qualification' => 'nullable|string|in:technical,licentiate,bachelor,postgraduate,master,doctorate',
            'status' => 'in:active,inactive,on_leave',
        ]);

        $teacher->update($request->all());

        $subjectName = $request->subject_name === 'new'
            ? $request->new_subject_name
            : $request->subject_name;

        if ($subjectName) {
            $subject = Subject::firstOrCreate(
                ['name' => $subjectName],
                [
                    'code' => strtoupper(substr($subjectName, 0, 3)) . rand(100, 999),
                    'teacher_id' => $teacher->id,
                    'status' => 'active',
                ]
            );
            $subject->update(['teacher_id' => $teacher->id]);
        }

        return redirect()->route('teachers.index')->with('success', 'Professor atualizado com sucesso!');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Professor excluído com sucesso!');
    }
}
