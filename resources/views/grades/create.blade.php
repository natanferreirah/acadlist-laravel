@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Cadastrar Nota</h1>

    <form method="POST" action="{{ route('grades.store') }}">
        @csrf

        <div class="mb-3">
            <label>Aluno:</label>
            <select name="student_id" class="border rounded p-2 w-full" required>
                <option value="">Selecione</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Turma:</label>
            <select name="school_class_id" class="border rounded p-2 w-full" required>
                <option value="">Selecione</option>
                @foreach($schoolClasses as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Matéria:</label>
            <select name="subject_id" class="border rounded p-2 w-full" required>
                <option value="">Selecione</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Professor:</label>
            <select name="teacher_id" class="border rounded p-2 w-full" required>
                <option value="">Selecione</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Bimestre:</label>
            <input type="number" name="bimester" min="1" max="4" class="border rounded p-2 w-full" required>
        </div>

        <div class="mb-3">
            <label>Nota:</label>
            <input type="number" step="0.1" min="0" max="10" name="grade" class="border rounded p-2 w-full" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Salvar</button>
    </form>
</div>
@endsection
