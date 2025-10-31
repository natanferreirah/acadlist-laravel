@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-6">Matérias</h1>

    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('subjects.index') }}">
            <select name="turma" onchange="this.form.submit()"
                class="border rounded-lg px-3 py-2 text-gray-700">
                <option value="">Todas as turmas</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ $turmaId == $turma->id ? 'selected' : '' }}>
                        {{ $turma->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <a href="{{ route('subjects.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
           + Nova Matéria
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">Matéria</th>
                <th class="px-4 py-2 border-b">Professor</th>
                <th class="px-4 py-2 border-b">Turma</th>
                <th class="px-4 py-2 border-b">Série</th>
                <th class="px-4 py-2 border-b text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subjects as $subject)
                @foreach($subject->teachers as $teacher)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $subject->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $teacher->name }}</td>
                        <td class="px-4 py-2 border-b">
                            {{ \App\Models\SchoolClass::find($teacher->pivot->school_class_id)->name ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border-b">{{ $subject->grade_level }}</td>
                        <td class="px-4 py-2 border-b text-center">
                            <a href="{{ route('subjects.edit', $subject) }}" class="text-blue-600 hover:underline">Editar</a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
