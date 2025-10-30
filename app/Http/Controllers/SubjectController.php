<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('teachers')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects',
            'workload' => 'integer|nullable',
            'grade_level' => 'string|nullable',
            'status' => 'in:active,inactive',
        ]);

        $created = Subject::create($validated);

        if ($created) {
            return redirect()->route('subjects.index')->with('success', 'Matéria cadastrada!');           
        }
            return redirect()->back()->with('error', 'Erro ao cadastrar matéria');
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'workload' => 'integer|nullable',
            'grade_level' => 'string|nullable',
            'status' => 'in:active,inactive',
        ]);

        $updated = $subject->update($validated);

        if ($updated) {
            return redirect()->route('subjects.index')->with('success', 'Matéria atualizada!');
        }
            return redirect()->back()->with('error', 'Erro ao atualizar matéria');  
    }

    public function destroy(Subject $subject)
    {
        $deleted = $subject->delete();

        if ($deleted) {
            return redirect()->route('subjects.index')->with('success', 'Matéria excluída!');
        }
            return redirect()->back()->with('error', 'Erro ao excluir matéria');
    }
}
