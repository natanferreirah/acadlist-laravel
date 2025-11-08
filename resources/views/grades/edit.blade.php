@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Editar Nota</h1>

    <form method="POST" action="{{ route('grades.update', $grade->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Aluno:</label>
            <input type="text" class="border rounded p-2 w-full bg-gray-100" value="{{ $grade->student->name }}" disabled>
        </div>

        <div class="mb-3">
            <label>Matéria:</label>
            <input type="text" class="border rounded p-2 w-full bg-gray-100" value="{{ $grade->subject->name }}" disabled>
        </div>

        <div class="mb-3">
            <label>Bimestre:</label>
            <input type="number" name="bimester" min="1" max="4" value="{{ $grade->bimester }}" class="border rounded p-2 w-full" required>
        </div>

        <div class="mb-3">
            <label>Nota:</label>
            <input type="number" step="0.1" min="0" max="10" name="grade" value="{{ $grade->grade }}" class="border rounded p-2 w-full" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Atualizar</button>
    </form>
</div>
@endsection
