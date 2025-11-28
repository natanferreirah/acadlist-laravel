<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $selectedYear = $request->input('year', date('Y'));
        
        $availableYears = SchoolClass::distinct()
            ->orderBy('school_year', 'desc')
            ->pluck('school_year');

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;
            
            if (!$teacher) {
                abort(403, 'Professor não vinculado ao usuário.');
            }

            $schoolClasses = SchoolClass::orderBy('name')->get();
            $subjects = $teacher->subjects;
            $selectedTeacher = $teacher->id;
            $teachers = collect();
        } else {
            $schoolClasses = SchoolClass::orderBy('name')->get();
            $subjects = Subject::all();
            $teachers = Teacher::all();
            $selectedTeacher = $request->input('teacher');
        }

        $selectedClass = $request->input('class');
        $selectedSubject = $request->input('subject');

        $students = collect();
        $grades = [];

        if ($selectedClass && $selectedSubject && $selectedTeacher && $selectedYear) {
            $students = Student::where('school_class_id', $selectedClass)->get();

            $gradesData = Grade::where('school_class_id', $selectedClass)
                ->where('subject_id', $selectedSubject)
                ->where('teacher_id', $selectedTeacher)
                ->where('year', $selectedYear)
                ->get();

            foreach ($gradesData as $g) {
                $grades[$g->student_id][$g->bimester][] = $g;
            }
        }

        return view('grades.index', [
            'schoolClasses' => $schoolClasses,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'students' => $students,
            'grades' => $grades,
            'selectedClass' => $selectedClass,
            'selectedSubject' => $selectedSubject,
            'selectedTeacher' => $selectedTeacher,
            'selectedYear' => $selectedYear,
            'userRole' => $user->role,
            'availableYears' => $availableYears,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'year' => 'required|integer|min:2000|max:2100',
            'grades' => 'required|array',
        ]);

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;
            if (!$teacher || $teacher->id != $validated['teacher_id']) {
                abort(403, 'Você só pode lançar notas como seu próprio professor.');
            }
            if (!$teacher->subjects->contains($validated['subject_id'])) {
                abort(403, 'Você não leciona essa matéria.');
            }
        }

        foreach ($validated['grades'] as $studentId => $bimesters) {
            foreach ($bimesters as $bimester => $gradeValue) {
                
                if ($gradeValue === null || $gradeValue === '' || trim($gradeValue) === '') {
                    continue;
                }

                // CONVERSÃO: vírgula → ponto
                $gradeValue = str_replace(',', '.', $gradeValue);
                $gradeValue = floatval($gradeValue);

                if ($gradeValue < 0 || $gradeValue > 10) {
                    return back()->withErrors([
                        'grades' => "Nota inválida: deve estar entre 0 e 10."
                    ])->withInput();
                }

                // Salva com PONTO no banco
                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $validated['subject_id'],
                        'school_class_id' => $validated['school_class_id'],
                        'teacher_id' => $validated['teacher_id'],
                        'bimester' => $bimester,
                        'year' => $validated['year'],
                    ],
                    [
                        'grade' => round($gradeValue, 2),
                    ]
                );
            }
        }

        return redirect()->route('grades.index', [
            'class' => $validated['school_class_id'],
            'subject' => $validated['subject_id'],
            'teacher' => $validated['teacher_id'],
            'year' => $validated['year'],
        ])->with('success', 'Notas salvas com sucesso!');
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;

            if (!$teacher) {
                abort(403, 'Professor não vinculado ao usuário.');
            }

            $schoolClasses = SchoolClass::whereHas('subjects', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->get();

            $subjects = $teacher->subjects;
            $teachers = collect([$teacher]);
        } else {
            $schoolClasses = SchoolClass::all();
            $subjects = Subject::all();
            $teachers = Teacher::all();
        }

        $years = range(date('Y') - 5, date('Y') + 1);

        return view('grades.create', compact('schoolClasses', 'subjects', 'teachers', 'years'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $grade = Grade::findOrFail($id);

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;

            if (!$teacher || $grade->teacher_id != $teacher->id) {
                abort(403, 'Você só pode editar suas próprias notas.');
            }
        }

        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $students = Student::where('school_class_id', $grade->school_class_id)->get();
        $years = range(date('Y') - 5, date('Y') + 1);

        return view('grades.edit', compact('grade', 'schoolClasses', 'subjects', 'teachers', 'students', 'years'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $grade = Grade::findOrFail($id);

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;

            if (!$teacher || $grade->teacher_id != $teacher->id) {
                abort(403, 'Você só pode atualizar suas próprias notas.');
            }
        }

        $data = $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $grade->update($data);

        return redirect()->route('grades.index')->with('success', 'Nota atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $grade = Grade::findOrFail($id);

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;

            if (!$teacher || $grade->teacher_id != $teacher->id) {
                abort(403, 'Você só pode deletar suas próprias notas.');
            }
        }

        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Nota excluída com sucesso!');
    }
}