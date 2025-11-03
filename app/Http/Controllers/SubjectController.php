<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        // Carrega matérias com seus professores
        $subjects = Subject::with('teacher')->orderBy('name')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        // Busca TODAS as matérias cadastradas com seus professores
        $defaultSubjects = Subject::with('teacher')
            ->orderBy('name')
            ->get();

        // Carrega todos os professores
        $teachers = Teacher::orderBy('name')->get();

        // 🔍 Log temporário pra depurar no arquivo storage/logs/laravel.log
        foreach ($defaultSubjects as $subject) {
            Log::info('MATÉRIA CARREGADA:', [
                'id' => $subject->id,
                'nome' => $subject->name,
                'teacher_id' => $subject->teacher_id,
                'professor' => $subject->teacher->name ?? 'SEM PROFESSOR',
            ]);
        }

        return view('subjects.create', compact('defaultSubjects', 'teachers'));
    }

    public function store(Request $request)
    {
        // Verifica se é uma matéria nova ou padrão
        $subjectName = $request->default_subject === 'new'
            ? $request->new_subject_name
            : Subject::find($request->default_subject)?->name;

        $request->validate([
            'teacher_id' => 'nullable|exists:teachers,id',
            'workload' => 'nullable|integer',
            'grade_level' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
        ]);

        // Cria a matéria
        Subject::create([
            'name' => $subjectName,
            'teacher_id' => $request->teacher_id,
            'code' => strtoupper(substr($subjectName, 0, 3)) . rand(100, 999),
            'workload' => $request->workload ?? 40,
            'grade_level' => $request->grade_level ?? '9º Ano',
            'status' => $request->status ?? 'active',
            'is_default' => false,
        ]);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Matéria cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $defaultSubjects = Subject::with('teacher')->get();
        $teachers = Teacher::orderBy('name')->get();

        return view('subjects.edit', compact('subject', 'defaultSubjects', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:subjects,code,' . $subject->id,
            'workload' => 'nullable|integer',
            'grade_level' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
            'workload' => $request->workload,
            'grade_level' => $request->grade_level,
            'status' => $request->status,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Matéria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Matéria excluída com sucesso!');
    }
}
