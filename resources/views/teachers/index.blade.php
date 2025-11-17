<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Professores
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
                <a href="{{ route('teachers.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Novo Professor
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-y-auto">
                    <table class="min-w-full text-sm text-center text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3">CPF</th>
                                <th class="px-4 py-3">Data Nasc.</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Telefone</th>
                                <th class="px-4 py-3">Endereço</th>
                                <th class="px-4 py-3">Data Contratação</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Qualificação</th>
                                <th class="px-4 py-3">Matérias</th>
                                <th class="px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teachers as $teacher)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->cpf }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->birth_date ? date('d/m/Y', strtotime($teacher->birth_date)) : '-' }}</td>
                                <td class="px-4 py-3">{{ $teacher->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->phone ?? 'Sem número de telefone' }}</td>
                                <td class="px-4 py-3">{{ $teacher->address ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $teacher->hire_date ? date('d/m/Y', strtotime($teacher->hire_date)) : '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs {{ $teacher->status == 'active' ? 'bg-green-100 text-green-700 font-semibold' : 'bg-red-100 text-red-700 font-semibold' }}">
                                        {{ ucfirst( $teacher->status === 'active' ? 'Ativo' : 'Inativo' ) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $qualificationOptions[$teacher->qualification] ?? '--' }}</td>
                                <td class="px-4 py-3">
                                    @forelse($teacher->subjects as $subject)
                                    {{ $subject->name }}@if(!$loop->last), @endif
                                    @empty
                                    <em class="text-gray-400">Nenhuma</em>
                                    @endforelse
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('teachers.edit', $teacher) }}"
                                        class="text-blue-600 hover:underline mr-2">Editar</a>

                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Deseja realmente excluir este professor?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4 text-gray-500">Nenhum professor cadastrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>