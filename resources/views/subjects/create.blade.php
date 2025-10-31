@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-6">Adicionar Matéria</h1>

    <form method="POST" action="{{ route('subjects.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Matéria</label>
            <select name="name" class="w-full border rounded-lg px-3 py-2">
                @foreach($materiasPadrao as $materia)
                    <option value="{{ $materia }}">{{ $materia }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Professor</label>
            <select name="teacher_id" class="w-full border rounded-lg px-3 py-2">
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Turma</label>
            <select name="school_class_id" class="w-full border rounded-lg px-3 py-2">
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->name }}</option>
                @endforeach
            </select>
        </div>
        <div>

            <label class="block text-gray-700">Code:</label>
            <input type="text" name="code" id="" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Salvar
        </button>
    </form>
</div>
@endsection
