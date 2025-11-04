<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with(['teachers', 'schoolClasses'])->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $defaultSubjects = Subject::$defaultSubjects; 
        $departmentOptions = Subject::$departmentOptions;
        $teachers = Teacher::all();
        $schoolclasses = SchoolClass::all();

        return view('subjects.create', compact('defaultSubjects', 'teachers', 'schoolclasses', 'departmentOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'custom_subject' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'workload' => 'nullable|integer',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'teachers' => 'array'
        ]);

        // Se for "outra matéria", pega o valor do campo custom_subject
        $subjectName = $request->name === 'other' ? $request->custom_subject : $request->name;

        $subject = Subject::create([
            'name' => $subjectName,
            'code' => $request->code,
            'workload' => $request->workload,
            'department' => $request->department,
            'status' => $request->status
        ]);

        if ($request->filled('teachers')) {
            $subject->teachers()->sync($request->teachers);
        }

        return redirect()->route('subjects.index')->with('success', 'Matéria criada com sucesso!');
    }

    public function edit(Subject $subject)
    {
        $defaultSubjects = Subject::$defaultSubjects;
        $departmentOptions = Subject::$departmentOptions;
        $teachers = Teacher::all();
        $schoolclasses = SchoolClass::all();

        return view('subjects.edit', compact('defaultSubjects', 'departmentOptions', 'teachers', 'schoolclasses', 'subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'custom_subject' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'workload' => 'nullable|integer',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'teachers' => 'array'
        ]);

        $subjectName = $request->name === 'other' ? $request->custom_subject : $request->name;

        $subject->update([
            'name' => $subjectName,
            'code' => $request->code,
            'workload' => $request->workload,
            'department' => $request->department,
            'status' => $request->status
        ]);

        $subject->teachers()->sync($request->teachers ?? []);

        return redirect()->route('subjects.index')->with('success', 'Matéria atualizada com sucesso!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Matéria deletada com sucesso!');
    }
}
