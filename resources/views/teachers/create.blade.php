<x-app-layout>
<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-6">Cadastrar Professor</h1>

    <form action="{{ route('teachers.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-gray-700">Nome</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label for="cpf" class="block text-gray-700">CPF</label>
            <input type="text" name="cpf" class="w-full border-gray-300 rounded-lg" maxlength="11" required>
        </div>

        <div>
            <label for="email" class="block text-gray-700">E-mail</label>
            <input type="email" name="email" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label for="birth_date" class="block text-gray-700" id="birth_date">Data de Aniversário</label>
            <input type="date" id="birth_date" class="w-full border-gray-300 rounded-lg">
        </div>

        <div>
            <label for="hire_date" class="block text-gray-700" id="hire_date">Data de Contratação</label>
            <input type="date" id="hire_date" class="w-full border-gray-300 rounded-lg">
        </div>

        <div>
            <label for="status" class="block text-gray-700">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
        </div>


        <div>
            <label for="" class="block text-gray-700">Qualificação</label>
            <select name="qualification" class="w-full border-gray-300 rounded-lg">
                @foreach($qualificationOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="" class="block text-gray-700">Matérias</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($subjects as $subject)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}">
                        <span>{{ $subject->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            Salvar
        </button>
        <a href="{{ route('teachers.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
</x-app-layout>
