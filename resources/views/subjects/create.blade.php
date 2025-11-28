<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastrar Matéria
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

                    <form action="{{ route('subjects.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nome da Matéria -->
                        <div>
                            <label for="subject_select" class="block text-sm font-medium text-gray-700 mb-1">Nome da Matéria *</label>
                            <select id="subject_select" 
                                    name="name" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                    required>
                                <option value="">Selecione uma matéria</option>
                                @foreach($defaultSubjects as $subjectName)
                                <option value="{{ $subjectName }}" {{ old('name') == $subjectName ? 'selected' : '' }}>
                                    {{ $subjectName }}
                                </option>
                                @endforeach
                                <option value="other" {{ old('name') == 'other' ? 'selected' : '' }}>Outra...</option>
                            </select>
                        </div>

                        <!-- Campo customizado -->
                        <div id="custom_subject_field" style="display:none;">
                            <label for="custom_subject" class="block text-sm font-medium text-gray-700 mb-1">Nova Matéria *</label>
                            <input type="text" 
                                   id="custom_subject" 
                                   name="custom_subject" 
                                   value="{{ old('custom_subject') }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Digite o nome da nova matéria">
                        </div>

                        <!-- Código e Carga Horária -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                                <input type="text" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Ex: MAT">
                            </div>

                            <div>
                                <label for="workload" class="block text-sm font-medium text-gray-700 mb-1">Carga Horária (horas)</label>
                                <input type="number" 
                                       id="workload" 
                                       name="workload" 
                                       value="{{ old('workload') }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Ex: 60">
                            </div>
                        </div>

                        <!-- Departamento e Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Departamento *</label>
                                <select id="department" 
                                        name="department" 
                                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                        required>
                                    <option value="">-- Selecione --</option>
                                    @foreach($departmentOptions as $key => $label)
                                    <option value="{{ $key }}" {{ old('department') == $key ? 'selected' : '' }}>
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
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Ativa</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inativa</option>
                                </select>
                            </div>
                        </div>

                        <!-- Professores -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Professores</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50 max-h-60 overflow-y-auto">
                                @forelse($teachers as $teacher)
                                <label class="flex items-center space-x-2 cursor-pointer hover:bg-white p-2 rounded transition">
                                    <input type="checkbox" 
                                           name="teachers[]" 
                                           value="{{ $teacher->id }}"
                                           {{ in_array($teacher->id, old('teachers', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $teacher->name }}</span>
                                </label>
                                @empty
                                <p class="col-span-2 text-gray-500 text-sm">Nenhum professor cadastrado.</p>
                                @endforelse
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Selecione os professores que lecionam esta matéria</p>
                        </div>

                        <!-- Botões -->
                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t">
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Salvar Matéria
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

    <script>
        (function(){
            const select = document.getElementById('subject_select');
            const customField = document.getElementById('custom_subject_field');
            const customInput = document.getElementById('custom_subject');
            
            if (!select || !customField || !customInput) return;

            select.addEventListener('change', function() {
                if (this.value === 'other') {
                    customField.style.display = 'block';
                    customInput.required = true;
                } else {
                    customField.style.display = 'none';
                    customInput.required = false;
                    customInput.value = '';
                }
            });

            // Se já vier com "other" selecionado (old input)
            if (select.value === 'other') {
                customField.style.display = 'block';
                customInput.required = true;
            }
        })();
    </script>
</x-app-layout>