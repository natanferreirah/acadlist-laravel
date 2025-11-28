<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Turma
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('school-classes.update', $school_class) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome da Turma *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $school_class->name) }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Ex: 3º Ano A"
                                   required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="assigned_room" class="block text-sm font-medium text-gray-700 mb-1">Sala Atribuída *</label>
                                <input type="text" 
                                       id="assigned_room" 
                                       name="assigned_room" 
                                       value="{{ old('assigned_room', $school_class->assigned_room) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Ex: Sala 12"
                                       required>
                            </div>

                            <div>
                                <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Série *</label>
                                <input type="text" 
                                       id="grade" 
                                       name="grade" 
                                       value="{{ old('grade', $school_class->grade) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Ex: 3º Ano"
                                       required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="school_year" class="block text-sm font-medium text-gray-700 mb-1">Ano Letivo *</label>
                                <input type="number" 
                                       id="school_year" 
                                       name="school_year" 
                                       value="{{ old('school_year', $school_class->school_year) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="2025"
                                       min="2000"
                                       max="2100"
                                       required>
                            </div>

                            <div>
                                <label for="shift" class="block text-sm font-medium text-gray-700 mb-1">Turno *</label>
                                <select id="shift" 
                                        name="shift" 
                                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                        required>
                                    <option value="">Selecione o turno</option>
                                    @foreach($shiftOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('shift', $school_class->shift) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t">
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Atualizar Turma
                            </button>
                            <a href="{{ route('school-classes.index') }}" 
                               class="w-full sm:w-auto bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors font-medium text-center">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>