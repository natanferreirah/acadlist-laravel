<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow mt-10">

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notas
            </h2>
        </x-slot>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('grades.index') }}" class="flex flex-wrap gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Turma:</label>
                <select name="class" class="border rounded p-2 w-40">
                    <option value="">Selecione</option>
                    @foreach($schoolClasses as $class)
                    <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Matéria:</label>
                <select name="subject" class="border rounded p-2 w-40">
                    <option value="">Selecione</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">
                        {{ $subject->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Professor:</label>
                <select name="teacher" class="border rounded p-2 w-40">
                    <option value="">Selecione</option>
                    @if($teacher)
                    <option value="{{ $teacher->id }}" selected>
                        {{ $teacher->name }}
                    </option>
                    @endif
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded my-auto  hover:bg-blue-700">
                Filtrar
            </button>
        </form>

        {{-- PLANILHA DE NOTAS --}}
        @if($students->count() > 0)
        <form method="POST" action="{{ route('grades.store') }}">
            @csrf
            <input type="hidden" name="school_class_id" value="{{ $selectedClass }}">
            <input type="hidden" name="subject_id" value="{{ $selectedSubject }}">
            <input type="hidden" name="teacher_id" value="{{ $selectedTeacher }}">

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border text-center">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Aluno</th>
                            @for ($b = 1; $b <= 4; $b++)
                                <th class="border p-2">{{ $b }}º Bimestre</th>
                                @endfor
                                <th class="border p-2">Média</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        @php $sum = 0; $count = 0; @endphp
                        <tr>
                            <td class="border p-2 text-left">{{ $student->name }}</td>

                            @for ($b = 1; $b <= 4; $b++)
                                @php
                                $gradeValue=$grades[$student->id][$b][0]->grade ?? '';
                                if(is_numeric($gradeValue)) { $sum += $gradeValue; $count++; }
                                $isLow = is_numeric($gradeValue) && $gradeValue < 6;
                                    @endphp
                                    <td class="border p-1">
                                    <input
                                        type="number"
                                        step="0.1"
                                        min="0"
                                        max="10"
                                        name="grades[{{ $student->id }}][{{ $b }}]"
                                        value="{{ $gradeValue }}"
                                        class="w-16 text-center border rounded focus:ring-2 focus:ring-blue-400 {{ $isLow ? 'bg-red-100' : '' }}">
                                    </td>
                                    @endfor

                                    <td class="border p-2 font-semibold">
                                        {{ $count > 0 ? number_format($sum / $count, 1) : '-' }}
                                    </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                💾 Salvar Notas
            </button>
        </form>
        @else
        <p class="text-gray-600 mt-4">Selecione uma turma e uma matéria para visualizar os alunos.</p>
        @endif
    </div>
</x-app-layout>