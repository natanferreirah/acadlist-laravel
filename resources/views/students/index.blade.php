<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alunos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {!! session('success') !!}
            </div>
            @endif
            @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                {!! session('error') !!}
            </div>
            @endif

            <div class="flex justify-end mb-4">
                <a href="{{ route('students.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Novo Aluno
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3">CPF</th>
                                <th class="px-4 py-3">Data de Nascimento</th>
                                <th class="px-4 py-3">Turma</th>
                                <th class="px-4 py-3">Série</th>
                                <th class="px-4 py-3">Turno</th>
                                <th class="px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $student->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-medium">{{ $student->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $student->cpf_formatado }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">{{ $student->schoolClass->name ?? 'Sem turma' }}</td>
                                <td class="px-4 py-3">{{ $student->schoolClass->grade ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($student->schoolClass)
                                    <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700 font-semibold">
                                        {{ $student->schoolClass->shift_label }}
                                    </span>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('students.edit', $student->id) }}"
                                        class="text-blue-600 hover:underline mr-2">Editar</a>

                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Tem certeza que deseja excluir o aluno {{ $student->name }}?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">Nenhum aluno cadastrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>