<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolclasses = SchoolClass::all();
        return view('schoolclasses.index', compact('schoolclasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shiftOptions = SchoolClass::$shiftOptions;
        return view('schoolclasses.create', compact('shiftOptions'));  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validated = $request->validate([
            'name' => 'required|string|max:255',
            'assigned_room' => 'required',
            'shift' => 'required|in:morning,afternoon,night,full',
            'school_year' => 'required',
            'grade' => 'required',
        ]);

        $created = SchoolClass::create($validated);

        if ($created) {
            return redirect()->route('school-classes.index')->with('sucess', 'Turma cadastrada com sucesso');
        }
            return redirect()->back()->with('error', 'Erro ao cadastrar turma');

    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $school_class)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $school_class)
    {
        $shiftOptions = SchoolClass::$shiftOptions;
        return view('schoolclasses.edit', compact('school_class', 'shiftOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $school_class)
    {
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'assigned_room' => 'required',
            'shift' => 'required|in:morning,afternoon,night,full',
            'school_year' => 'required',
            'grade' => 'required',
        ]);

        $updated = $school_class->update($validated);

        if($updated){
            return redirect()->route('school-classes.index')->with('sucess', 'Turma atualizada com sucesso');
        }
            return redirect()->back()->with('error', 'Erro ao atualizar turma');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $school_class)
    {
        $deleted = $school_class->delete();

        if ($deleted) {
            return redirect()->route('school-classes.index')->with('sucess', 'Turma excluída com sucesso');
        }   
            return redirect()->back()->with('error', 'Erro ao excluir turma');
    }
}
