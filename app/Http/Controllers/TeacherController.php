<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Log::info('===== INICIANDO STORE =====');
        Log::info('Dados recebidos:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:teachers,cpf',
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:teachers,email|unique:users,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'qualification' => 'required|string',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        Log::info('Validação passou');

        try {
            DB::beginTransaction();
            Log::info('Transaction iniciada');

            // ---------- Geração de username ----------
            $nameParts = explode(' ', Str::lower(Str::ascii($request->name)));
            $first = $nameParts[0];
            $last = count($nameParts) > 1 ? end($nameParts) : '';
            $baseUsername = $last ? "{$first}.{$last}" : $first;

            $username = $baseUsername;
            $count = 1;

            while (User::where('username', $username)->exists()) {
                $username = "{$baseUsername}{$count}";
                $count++;
            }

            Log::info('Username gerado: ' . $username);

            // ---------- Cria o usuário vinculado ----------
            $defaultPassword = 'Prof@' . date('Y');
            
            $user = User::create([
                'username' => $username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($defaultPassword),
                'role' => 'teacher',
            ]);

            Log::info('Usuário criado:', ['id' => $user->id]);

            // ---------- Cria o professor ----------
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'cpf' => $request->cpf,
                'birth_date' => $request->birth_date,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'hire_date' => $request->hire_date,
                'status' => $request->status,
                'qualification' => $request->qualification,
            ]);

            Log::info('Professor criado:', ['id' => $teacher->id]);

            // ---------- Relaciona as matérias ----------
            if ($request->has('subjects')) {
                $teacher->subjects()->sync($request->subjects);
                Log::info('Matérias vinculadas');
            }

            DB::commit();
            Log::info('Transaction commitada - SUCESSO!');

            return redirect()->route('teachers.index')
                ->with('success', "Professor cadastrado com sucesso!<br><strong>Login:</strong> {$username}<br><strong>Senha:</strong> {$defaultPassword}");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERRO ao criar professor: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar professor: ' . $e->getMessage());
        }
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
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:teachers,cpf,' . $teacher->id,
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id . '|unique:users,email,' . $teacher->user_id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'qualification' => 'required|string',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        try {
            DB::beginTransaction();

            // Atualiza os dados do professor
            $teacher->update($request->except('subjects'));

            // Atualiza as matérias
            $teacher->subjects()->sync($request->subjects ?? []);

            // Atualiza o usuário vinculado
            if ($teacher->user_id) {
                $user = User::find($teacher->user_id);
                if ($user) {
                    $user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('teachers.index')
                ->with('success', 'Professor atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar professor: ' . $e->getMessage());
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            DB::beginTransaction();

            // Deleta o usuário vinculado
            if ($teacher->user_id) {
                User::where('id', $teacher->user_id)->delete();
            }

            // Desvincula as matérias antes de deletar
            $teacher->subjects()->detach();

            // Deleta o professor
            $teacher->delete();

            DB::commit();

            return redirect()->route('teachers.index')
                ->with('success', 'Professor removido com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('teachers.index')
                ->with('error', 'Erro ao remover professor: ' . $e->getMessage());
        }
    }
}