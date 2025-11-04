
<div class="container">
    <h1>Editar Matéria</h1>

    @php
        // Verifica se o nome da matéria não está nas padrões
        $isCustom = isset($subject) && isset($defaultSubjects)
            ? !in_array($subject->name, $defaultSubjects)
            : false;
    @endphp

    <form method="POST" action="{{ route('subjects.update', $subject->id) }}">
        @csrf
        @method('PUT')

        {{-- Nome da matéria --}}
        <div>
            <label>Nome da Matéria:</label>
            <select id="subject_select" name="name" required>
                <option value="">Selecione uma matéria</option>
                @foreach($defaultSubjects as $subjectName)
                    <option value="{{ $subjectName }}" {{ $subject->name == $subjectName ? 'selected' : '' }}>
                        {{ $subjectName }}
                    </option>
                @endforeach
                <option value="other" {{ $isCustom ? 'selected' : '' }}>Outra...</option>
            </select>
        </div>

        {{-- Campo para nova matéria personalizada --}}
        <div id="custom_subject_field"
             @if($isCustom)
                 style="margin-top:10px;"
             @else
                 style="display:none;margin-top:10px;"
             @endif
        >
            <label>Nova Matéria:</label>
            <input type="text" name="custom_subject" value="{{ $isCustom ? $subject->name : '' }}" placeholder="Digite o nome da nova matéria">
        </div>

        {{-- Código --}}
        <div>
            <label>Código:</label>
            <input type="text" name="code" value="{{ old('code', $subject->code) }}">
        </div>

        {{-- Carga Horária --}}
        <div>
            <label>Carga Horária:</label>
            <input type="number" name="workload" value="{{ old('workload', $subject->workload) }}">
        </div>

        {{-- Departamento (select com opções fixas) --}}
        <div>
            <label>Departamento:</label>
            <select name="department" required>
                <option value="">-- Selecione --</option>
                @foreach($departmentOptions as $key => $label)
                    <option value="{{ $key }}" {{ old('department', $subject->department) == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div>
            <label>Status:</label>
            <select name="status" required>
                <option value="active" {{ $subject->status == 'active' ? 'selected' : '' }}>Ativa</option>
                <option value="inactive" {{ $subject->status == 'inactive' ? 'selected' : '' }}>Inativa</option>
            </select>
        </div>

        {{-- Professores --}}
        <div>
            <label>Professores:</label>
            <select name="teachers[]" multiple>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $subject->teachers->contains($teacher->id) ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
            <p style="font-size: 0.9em; color: #666;">(Segure CTRL para selecionar mais de um professor)</p>
        </div>

        <button type="submit">Atualizar</button>
    </form>
</div>

<script>
    // script simples para mostrar/esconder o campo customizado
    (function(){
        const select = document.getElementById('subject_select');
        const customField = document.getElementById('custom_subject_field');
        if (!select || !customField) return;

        select.addEventListener('change', function() {
            if (this.value === 'other') {
                customField.style.display = 'block';
                const input = customField.querySelector('input[name="custom_subject"]');
                if (input) input.required = true;
            } else {
                customField.style.display = 'none';
                const input = customField.querySelector('input[name="custom_subject"]');
                if (input) input.required = false;
            }
        });
    })();
</script>

