<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Aluno
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6" x-data="studentForm()">
                    @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('students.update', $student->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $student->name) }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Ex: João Silva Santos"
                                   required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF *</label>
                                <input type="text" 
                                       id="cpf" 
                                       name="cpf" 
                                       x-ref="cpfInput"
                                       value="{{ old('cpf', $student->cpf) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="000.000.000-00"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">Digite apenas números</p>
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento *</label>
                                <input type="date" 
                                       id="birth_date" 
                                       name="birth_date" 
                                       value="{{ old('birth_date', $student->birth_date) }}"
                                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                        </div>
                        <div>
                            <label for="school_class_id" class="block text-sm font-medium text-gray-700 mb-1">Turma *</label>
                            <select id="school_class_id" 
                                    name="school_class_id" 
                                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                    required>
                                <option value="">Selecione uma turma</option>
                                @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} - {{ $class->grade }} - {{ $class->shift_label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t">
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Atualizar Aluno
                            </button>
                            <a href="{{ route('students.index') }}" 
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
        function studentForm() {
            return {
                init() {
                    console.log('🎯 Inicializando máscara CPF para edição de aluno...');
                    
                    if (this.$refs.cpfInput) {
                        IMask(this.$refs.cpfInput, {
                            mask: '000.000.000-00'
                        });
                        console.log('✅ Máscara CPF aplicada no formulário de edição!');
                    }
                }
            }
        }
    </script>
</x-app-layout>