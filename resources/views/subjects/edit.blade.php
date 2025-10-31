@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-2xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Editar Matéria</h1>

    <form method="POST" action="{{ route('subjects.update', $subject) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700">Nome da Matéria</label>
            <input type="text" name="name" value="{{ $subject->name }}"
                   class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <button type="submit"
            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            Atualizar
        </button>
    </form>
</div>
@endsection
