<?php

namespace App\Http\Controllers;

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
        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        $selectedClass = $request->input('class');
        $selectedSubject = $request->input('subject');
        $selectedTeacher = $request->input('teacher');

        $students = collect();
        $grades = [];

        if ($selectedClass && $selectedSubject && $selectedTeacher) {
            $students = Student::where('school_class_id', $selectedClass)->get();

            // Busca todas as notas dessa turma + matéria + professor
            $gradesData = Grade::where('school_class_id', $selectedClass)
                ->where('subject_id', $selectedSubject)
                ->where('teacher_id', $selectedTeacher)
                ->get();

            // Organiza as notas por aluno e bimestre
            foreach ($gradesData as $g) {
                $grades[$g->student_id][$g->bimester][] = $g;
            }
        }

        return view('grades.index', compact(
            'schoolClasses',
            'subjects',
            'teachers',
            'students',
            'grades',
            'selectedClass',
            'selectedSubject',
            'selectedTeacher'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'grades' => 'required|array',
        ]);

        // Percorre cada aluno e salva as notas por bimestre
        foreach ($data['grades'] as $studentId => $bimesters) {
            foreach ($bimesters as $bimester => $gradeValue) {
                if ($gradeValue === null || $gradeValue === '') continue;

                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $data['subject_id'],
                        'school_class_id' => $data['school_class_id'],
                        'teacher_id' => $data['teacher_id'],
                        'bimester' => $bimester,
                    ],
                    [
                        'grade' => $gradeValue
                    ]
                );
            }
        }

        return redirect()->route('grades.index', [
            'class' => $data['school_class_id'],
            'subject' => $data['subject_id'],
            'teacher' => $data['teacher_id'],
        ])->with('success', 'Notas salvas com sucesso!');
    }

    public function create()
    {
        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('grades.create', compact('schoolClasses', 'subjects', 'teachers'));
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $students = Student::where('school_class_id', $grade->school_class_id)->get();

        return view('grades.edit', compact('grade', 'schoolClasses', 'subjects', 'teachers', 'students'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update($data);

        return redirect()->route('grades.index')->with('success', 'Nota atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Nota excluída com sucesso!');
    }
}
