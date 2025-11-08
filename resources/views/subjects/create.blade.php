@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow p-6 rounded-2xl">
    <h1 class="text-2xl font-bold mb-6">Adicionar Nova Matéria</h1>

    <form method="POST" action="{{ route('subjects.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Nome da Matéria</label>
            <select id="subject_select" name="name" required class="border rounded p-2 w-50">
                <option value="">Selecione uma matéria</option>
                @foreach($defaultSubjects as $subjectName)
                <option value="{{ $subjectName }}">{{ $subjectName }}</option>
                @endforeach
                <option value="other">Outra...</option>
            </select>

            <div id="custom_subject_field" style="display:none; margin-top: 10px;">
                <label>Nova Matéria:</label>
                <input type="text" name="custom_subject" placeholder="Digite o nome da nova matéria" class="border rounded p-2 w-50">
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Código</label>
            <input type="text" name="code" class="border rounded p-2 w-50" placeholder="Ex: MAT">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Carga Horária</label>
            <input type="number" name="workload" class="border rounded p-2 w-50" placeholder="Ex: 20">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Departamento</label>
            <select name="department" required class="border rounded p-2 w-full">
                <option value="">-- Selecione --</option>
                @foreach($departmentOptions as $key => $label)
                <option value="{{ $key }}"
                    @if(old('department', isset($subject) ? $subject->deprtment : '') == $key) selected @endif>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Status</label>
            <select name="status" class="border rounded p-2 w-50">
                <option value="active">Ativa</option>
                <option value="inactive">Inativa</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block font-semibold">Professores</label>
            <select name="teachers[]" multiple class="border rounded p-2 w-50">
                @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
    </form>
</div>

<script>
    const select = document.getElementById('subject_select');
    const customField = document.getElementById('custom_subject_field');

    select.addEventListener('change', function() {
        if (this.value === 'other') {
            customField.style.display = 'block';
            customField.querySelector('input').required = true;
        } else {
            customField.style.display = 'none';
            customField.querySelector('input').required = false;
        }
    });
</script>
@endsection