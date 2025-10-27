<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('schoolClass')->get();
        return view('student.index', compact('students'));
    }

    function create()
    {
        $schoolClasses = SchoolClass::all();
        return view('student.create', compact('schoolClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => 'required|unique:students',
            'birth_date' => 'required|date',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        $created = Student::create($request->all());

        if ($created) {
            return redirect()->route('students.index')->with('sucess', 'Aluno cadastrado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao cadastrar Aluno');
        }
    }

    public function show(Student $student)
    {
        //
    }

    public function edit(Student $student)
    {
        $schoolClasses = SchoolClass::all();
        $edited = Student::findorfail($student->id);

        return view('student.edit',  compact('student', 'schoolClasses'));
    }

    public function update(Request $request, Student $student)
    {
          $request->validate([
            'name' => 'required',
            'cpf' => 'required|unique:students,cpf,' . $student->id,
            'birth_date' => 'required|date',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        $students = Student::findorfail($student->id);

        $updated = $students->update($request->all());

        if ($updated) {
            return redirect()->route('students.index')->with('sucess', 'Aluno atualizado com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar aluno');
        }
    }

    public function destroy(Student $student)
    {
        $students = Student::findorfail($student->id);

        $deleted = $students->delete();

        if ($deleted) {
            return redirect()->route('students.index')->with('sucess', 'Aluno excluído com sucesso');
        } else {
            return redirect()->back()->with('error', 'Erro ao excluír aluno');
        }
    }
}
