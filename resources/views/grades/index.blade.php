<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerenciar Notas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="GET" action="{{ route('grades.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ano Letivo</label>
                                <select name="year" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Selecione o ano</option>
                                    @foreach ($availableYears as $year)
                                        <option value="{{ $year }}"
                                            {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
                                <select name="class" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Selecione a turma</option>
                                    @foreach ($schoolClasses as $class)
                                        <option value="{{ $class->id }}"
                                            {{ $selectedClass == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }} ({{ $class->school_year }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Matéria</label>
                                <select name="subject" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Selecione a matéria</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Professor</label>

                                @if ($userRole === 'school')
                                    <select name="teacher" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Selecione o professor</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                {{ $selectedTeacher == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" value="{{ Auth::user()->teacher->name }}"
                                        class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled>

                                    <input type="hidden" name="teacher" value="{{ Auth::user()->teacher->id }}">
                                @endif
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                    </svg>
                                    Buscar
                                </button>
                            </div>

                        </div>
                    </form>
                    @if ($students->count() > 0)

                        <form method="POST" action="{{ route('grades.store') }}">
                            @csrf

                            <input type="hidden" name="school_class_id" value="{{ $selectedClass }}">
                            <input type="hidden" name="subject_id" value="{{ $selectedSubject }}">
                            <input type="hidden" name="teacher_id" value="{{ $selectedTeacher }}">
                            <input type="hidden" name="year" value="{{ $selectedYear }}">

                            <div class="overflow-x-auto rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Aluno
                                            </th>
                                            @for ($b = 1; $b <= 4; $b++)
                                                <th
                                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                    {{ $b }}º Bim
                                                </th>
                                            @endfor
                                            <th
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                Média
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($students as $student)
                                            @php
                                                $sum = 0;
                                                $count = 0;
                                            @endphp

                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    {{ $student->name }}
                                                </td>

                                                @for ($b = 1; $b <= 4; $b++)
                                                    @php
                                                        $gradeVal = $grades[$student->id][$b][0]->grade ?? null;

                                                        // Converte PONTO → VÍRGULA para exibir
                                                        $displayValue = '';
                                                        if ($gradeVal !== null && $gradeVal !== '') {
                                                            $displayValue = number_format(
                                                                (float) $gradeVal,
                                                                2,
                                                                ',',
                                                                '',
                                                            );
                                                        }

                                                        $isLow = is_numeric($gradeVal) && $gradeVal < 6;

                                                        if (is_numeric($gradeVal)) {
                                                            $sum += $gradeVal;
                                                            $count++;
                                                        }
                                                    @endphp

                                                    <td class="px-6 py-4 text-center">
                                                        <input type="text" inputmode="decimal"
                                                            name="grades[{{ $student->id }}][{{ $b }}]"
                                                            value="{{ $displayValue }}" maxlength="5"
                                                            placeholder="0,00"
                                                            class="w-20 text-center border-gray-300 rounded-md shadow-sm {{ $isLow ? 'bg-red-50 border-red-300' : '' }}"
                                                            oninput="
                                                        var val = this.value.replace(/[^0-9]/g, '');
                                                        if (val === '') { this.value = ''; return; }
                                                        var num = parseInt(val);
                                                        if (num > 1000) num = 1000;
                                                        var formatted = (num / 100).toFixed(2).replace('.', ',');
                                                        this.value = formatted;
                                                    "
                                                            onblur="
                                                        var val = this.value.trim();
                                                        if (val === '' || val === '0,00') { this.value = ''; return; }
                                                        var num = parseFloat(val.replace(',', '.'));
                                                        if (isNaN(num)) { this.value = ''; return; }
                                                        if (num < 0) num = 0;
                                                        if (num > 10) num = 10;
                                                        this.value = num.toFixed(2).replace('.', ',');
                                                    ">
                                                    </td>
                                                @endfor
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold {{ $count > 0 && $sum / $count < 6 ? 'text-red-600' : 'text-green-600' }}">
                                                    {{ $count > 0 ? number_format($sum / $count, 1, ',', '') : '-' }}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit"
                                    class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition font-medium">

                                    Salvar Notas
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum aluno encontrado</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if (!$selectedClass || !$selectedSubject || !$selectedTeacher || !$selectedYear)
                                    Preencha todos os filtros acima para visualizar os alunos.
                                @else
                                    Não há alunos cadastrados para os filtros selecionados.
                                @endif
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
