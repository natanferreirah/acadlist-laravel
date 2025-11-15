<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('subjects')->get();
        $qualificationOptions = Teacher::$qualificationOptions;
        return view('teachers.index', compact('teachers', 'qualificationOptions'));
    }

    public function create()
    {
        $qualificationOptions = Teacher::$qualificationOptions;
        $subjects = Subject::all();
        return view('teachers.create', compact('qualificationOptions', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:teachers,cpf',
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:teachers,email|unique:users,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|string',
            'qualification' => 'required|string',
            'subjects' => 'array'
        ]);

        // Garante que o birth_date pode ser nulo
        $request['birth_date'] = $request->birth_date ?? null;

        // Cria o professor
        $teacher = Teacher::create($request->except('subjects'));

        // Relaciona as matérias
        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        // ---------- Geração de username ----------
        $nameParts = explode(' ', Str::lower(Str::ascii($teacher->name)));
        $first = $nameParts[0];
        $last = count($nameParts) > 1 ? end($nameParts) : '';
        $baseUsername = "{$first}.{$last}" ?: $first;

        $username = $baseUsername;
        $count = 1;

        // Garante que o username seja único
        while (User::where('username', $username)->exists()) {
            $username = "{$baseUsername}{$count}";
            $count++;
        }

        // ---------- Cria o usuário vinculado ----------
        $user = User::create([
            'username' => $username,
            'name' => $teacher->name,
            'email' => $teacher->email,
            'password' => Hash::make('prof123'),
            'role' => 'teacher',
        ]);

        // Vincula o professor ao usuário
        $teacher->user_id = $user->id;
        $teacher->save();

        return redirect()->route('teachers.index')
            ->with('success', "Professor cadastrado com sucesso! 
            Login: {$username} | Senha: prof123");
    }

    public function edit(Teacher $teacher)
    {
        $qualificationOptions = Teacher::$qualificationOptions;
        $subjects = Subject::all();
        return view('teachers.edit', compact('teacher', 'qualificationOptions', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string',
            'cpf' => 'required|string|unique:teachers,cpf,' . $teacher->id,
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|string',
            'qualification' => 'required|string',
            'subjects' => 'array'
        ]);

        // Atualiza os dados do professor
        $teacher->update($request->except('subjects'));

        // Atualiza as matérias
        $teacher->subjects()->sync($request->subjects ?? []);

        // Atualiza o usuário vinculado
        if ($teacher->user_id) {
            $user = User::find($teacher->user_id);
            if ($user) {
                $user->update([
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                ]);
            }
        }

        return redirect()->route('teachers.index')
            ->with('success', 'Professor atualizado com sucesso!');
    }

    public function destroy(Teacher $teacher)
    {
        // Deleta também o usuário vinculado
        if ($teacher->user_id) {
            User::where('id', $teacher->user_id)->delete();
        }

        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Professor removido com sucesso!');
    }
}
