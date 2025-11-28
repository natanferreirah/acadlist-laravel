<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Matéria
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

                    @php
                        $isCustom = !in_array($subject->name, $defaultSubjects);
                    @endphp

                    <form action="{{ route('subjects.update', $subject->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="subject_select" class="block text-sm font-medium text-gray-700 mb-1">Nome da Matéria *</label>
                            <select id="subject_select" 
                                    name="name" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    onchange="toggleCustomField(this.value)" 
                                    required>
                                <option value="">Selecione uma matéria</option>
                                @foreach($defaultSubjects as $subjectName)
                                <option value="{{ $subjectName }}" {{ $subject->name == $subjectName ? 'selected' : '' }}>
                                    {{ $subjectName }}
                                </option>
                                @endforeach
                                <option value="other" {{ $isCustom ? 'selected' : '' }}>Outra...</option>
                            </select>
                        </div>

                        <div id="custom_subject_field" style="{{ $isCustom ? '' : 'display:none;' }}">
                            <label for="custom_subject" class="block text-sm font-medium text-gray-700 mb-1">Nova Matéria *</label>
                            <input type="text" 
                                   id="custom_subject" 
                                   name="custom_subject" 
                                   value="{{ $isCustom ? $subject->name : '' }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Digite o nome da nova matéria">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                                <input type="text" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code', $subject->code) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Ex: MAT">
                            </div>

                            <div>
                                <label for="workload" class="block text-sm font-medium text-gray-700 mb-1">Carga Horária (horas)</label>
                                <input type="number" 
                                       id="workload" 
                                       name="workload" 
                                       value="{{ old('workload', $subject->workload) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Ex: 60">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Departamento *</label>
                                <select id="department" 
                                        name="department" 
                                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                        required>
                                    <option value="">-- Selecione --</option>
                                    @foreach($departmentOptions as $key => $label)
                                    <option value="{{ $key }}" {{ old('department', $subject->department) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <select id="status" 
                                        name="status" 
                                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                        required>
                                    <option value="active" {{ $subject->status == 'active' ? 'selected' : '' }}>Ativa</option>
                                    <option value="inactive" {{ $subject->status == 'inactive' ? 'selected' : '' }}>Inativa</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Professores</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50 max-h-60 overflow-y-auto">
                                @forelse($teachers as $teacher)
                                <label class="flex items-center space-x-2 cursor-pointer hover:bg-white p-2 rounded transition">
                                    <input type="checkbox" 
                                           name="teachers[]" 
                                           value="{{ $teacher->id }}"
                                           {{ $subject->teachers->contains($teacher->id) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $teacher->name }}</span>
                                </label>
                                @empty
                                <p class="col-span-2 text-gray-500 text-sm">Nenhum professor cadastrado.</p>
                                @endforelse
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Selecione os professores que lecionam esta matéria</p>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t">
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Atualizar Matéria
                            </button>
                            <a href="{{ route('subjects.index') }}" 
                               class="w-full sm:w-auto bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors font-medium text-center">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleCustomField(value) {
            var field = document.getElementById('custom_subject_field');
            var input = document.getElementById('custom_subject');
            if (value === 'other') {
                field.style.display = 'block';
                input.required = true;
            } else {
                field.style.display = 'none';
                input.required = false;
            }
        }
    </script>
    @endpush
</x-app-layout>