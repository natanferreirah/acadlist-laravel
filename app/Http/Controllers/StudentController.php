<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }

    function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $created = Student::create($request->all());

        if ($created) {
            return redirect()->route('students.index')->with('sucess', 'Aluno cadastrado com sucesso');
        }
        else {
            return redirect()->back()->with('error', 'Erro ao cadastrar Aluno');
       } 

    }

    public function show(Student $student)
    {
        //
    }

    public function edit(Student $student)
    {
        $edited = Student::findorfail($student->id);
        
        return view('student.edit', compact('student'));

    }

    public function update(Request $request, Student $student)
    {
        $students = Student::findorfail($student->id);

        $updated = $students->update($request->all());

        if ($updated) {
            return redirect()->route('students.index')->with('sucess', 'Aluno atualizado com sucesso');
        }
        else {
            return redirect()->back()->with('error', 'Erro ao atualizar aluno');
        }
    }

    public function destroy(Student $student)
    {
        $students = Student::findorfail($student->id);

        $deleted = $students->delete();

        if ($deleted) {
            return redirect()->route('students.index')->with('sucess', 'Aluno excluído com sucesso');
        }
        else{
            return redirect()->back()->with('error', 'Erro ao excluír aluno');
        }
    }
}
