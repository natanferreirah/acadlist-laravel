<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Professor
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

                    <form action="{{ route('teachers.update', $teacher) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $teacher->name) }}"
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
                                   value="{{ old('cpf', $teacher->cpf) }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="000.000.000-00" 
                                   required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $teacher->email) }}"
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
                                   value="{{ old('phone', $teacher->phone) }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="(00) 00000-0000">
                        </div>

                        <!-- Resto dos campos... (copie do create) -->

                        <!-- Botões -->
                        <div class="flex items-center gap-3 pt-4 border-t">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Atualizar Professor
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