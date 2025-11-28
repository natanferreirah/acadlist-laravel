<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Turmas
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
                <a href="{{ route('school-classes.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Nova Turma
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3">Sala Atribuída</th>
                                <th class="px-4 py-3">Série</th>
                                <th class="px-4 py-3">Ano Letivo</th>
                                <th class="px-4 py-3">Turno</th>
                                <th class="px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schoolclasses as $s)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $s->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-medium">{{ $s->name }}</td>
                                <td class="px-4 py-3">{{ $s->assigned_room }}</td>
                                <td class="px-4 py-3">{{ $s->grade }}</td>
                                <td class="px-4 py-3">{{ $s->school_year }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700 font-semibold">
                                        {{ $s->shift_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('school-classes.edit', $s->id) }}"
                                        class="text-blue-600 hover:underline mr-2">Editar</a>

                                    <form action="{{ route('school-classes.destroy', $s->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Deseja realmente excluir esta turma?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Nenhuma turma cadastrada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>