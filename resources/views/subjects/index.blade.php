<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Matérias
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
                <a href="{{ route('subjects.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Nova Matéria
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3">Código</th>
                                <th class="px-4 py-3">Carga Horária</th>
                                <th class="px-4 py-3">Departamento</th>
                                <th class="px-4 py-3">Professores</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subjects as $subject)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $subject->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $subject->display_name }}</td>
                                <td class="px-4 py-3">{{ $subject->code }}</td>
                                <td class="px-4 py-3">{{ $subject->workload }}h</td>
                                <td class="px-4 py-3">{{ $subject->department_options }}</td>
                                <td class="px-4 py-3">
                                    @if($subject->teachers->isNotEmpty())
                                    {{ $subject->teachers->pluck('name')->join(', ') }}
                                    @else
                                    <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs {{ $subject->status == 'active' ? 'bg-green-100 text-green-700 font-semibold' : 'bg-red-100 text-red-700 font-semibold' }}">
                                        {{ $subject->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('subjects.edit', $subject) }}"
                                        class="text-blue-600 hover:underline mr-2">Editar</a>

                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Deseja realmente excluir esta matéria?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">Nenhuma matéria cadastrada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>