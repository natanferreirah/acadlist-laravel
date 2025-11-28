<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastrar Professor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6" x-data="teacherForm()">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('teachers.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF *</label>
                            <input type="text" 
                                   id="cpf" 
                                   name="cpf" 
                                   x-ref="cpfInput"
                                   value="{{ old('cpf') }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="000.000.000-00" 
                                   required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   x-ref="phoneInput"
                                   value="{{ old('phone') }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="(00) 00000-0000">
                        </div>

                        <!-- Endereço -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Datas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento</label>
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="hire_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Contratação</label>
                                <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Status e Qualificação -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <select id="status" name="status"
                                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>

                            <div>
                                <label for="qualification" class="block text-sm font-medium text-gray-700 mb-1">Qualificação</label>
                                <select id="qualification" name="qualification"
                                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecione...</option>
                                    @foreach ($qualificationOptions as $key => $option)
                                        <option value="{{ $key }}" {{ old('qualification') == $key ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Matérias -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Matérias</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                @forelse($subjects as $subject)
                                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-white p-2 rounded transition">
                                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                            {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-700">{{ $subject->name }}</span>
                                    </label>
                                @empty
                                    <p class="col-span-2 md:col-span-3 text-gray-500 text-sm">Nenhuma matéria cadastrada.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="flex items-center gap-3 pt-4 border-t">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Salvar Professor
                            </button>
                            <a href="{{ route('teachers.index') }}"
                                class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para aplicar máscaras -->
    <script>
        function teacherForm() {
            return {
                init() {
                    console.log('🎯 Inicializando máscaras do formulário...');
                    
                    // Máscara CPF
                    if (this.$refs.cpfInput) {
                        IMask(this.$refs.cpfInput, {
                            mask: '000.000.000-00'
                        });
                        console.log('✅ Máscara CPF aplicada!');
                    }
                    
                    // Máscara Telefone
                    if (this.$refs.phoneInput) {
                        IMask(this.$refs.phoneInput, {
                            mask: [
                                { mask: '(00) 0000-0000' },
                                { mask: '(00) 00000-0000' }
                            ]
                        });
                        console.log('✅ Máscara Telefone aplicada!');
                    }
                }
            }
        }
    </script>
</x-app-layout>