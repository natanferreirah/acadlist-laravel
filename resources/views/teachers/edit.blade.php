<x-app-layout>
<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-6">Editar Professor</h1>

    <form action="{{ route('teachers.update', $teacher) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700">Nome</label>
            <input type="text" name="name" value="{{ $teacher->name }}" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">CPF</label>
            <input type="text" name="cpf" value="{{ $teacher->cpf }}" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">E-mail</label>
            <input type="email" name="email" value="{{ $teacher->email }}" class="w-full border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="ativo" {{ $teacher->status === 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="inativo" {{ $teacher->status === 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Qualificação</label>
            <select name="qualification" class="w-full border-gray-300 rounded-lg">
                @foreach($qualificationOptions as $option)
                    <option value="{{ $option }}" {{ $teacher->qualification === $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Matérias</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($subjects as $subject)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                            {{ in_array($subject->id, $teacher->subjects->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <span>{{ $subject->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Atualizar
        </button>
        <a href="{{ route('teachers.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
</x-app-layout>

