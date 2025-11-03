<div class="container mt-4">
    <h2>Cadastrar Nova Matéria</h2>

    {{-- Mensagens de erro --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('subjects.store') }}" method="POST" id="subjectForm">
        @csrf

        {{-- Matéria (padrão ou nova) --}}
        <div class="mb-3">
            <label for="default_subject" class="form-label">Matéria</label>
            <select name="default_subject" id="default_subject" class="form-select">
                <option value="">Selecione uma matéria...</option>
                @foreach ($defaultSubjects as $subject)
                <option
                    value="{{ $subject->id }}"
                    data-teacher="{{ $subject->teacher?->id ?? '' }}"
                    data-teacher-name="{{ $subject->teacher?->name ?? 'Sem professor' }}">
                    {{ $subject->name }}
                </option>
                @endforeach
                <option value="new">+ Criar nova matéria</option>
                </select>
        </div>

        {{-- Nome da nova matéria --}}
        <div class="mb-3 d-none" id="new_subject_name_wrapper">
            <label for="new_subject_name" class="form-label">Nome da nova matéria</label>
            <input type="text" name="new_subject_name" id="new_subject_name" class="form-control" placeholder="Digite o nome da matéria">
        </div>

        {{-- Professor --}}
        <div class="mb-3">
            <label for="teacher_id" class="form-label">Professor</label>
            <select name="teacher_id" id="teacher_id" class="form-select">
                <option value="">Selecione o professor...</option>
                @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Código --}}
        <div class="mb-3">
            <label for="code" class="form-label">Código</label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Ex: MAT123">
        </div>

        {{-- Carga Horária --}}
        <div class="mb-3">
            <label for="workload" class="form-label">Carga Horária (em horas)</label>
            <input type="number" name="workload" id="workload" class="form-control" placeholder="Ex: 40">
        </div>

        {{-- Série/Nível --}}
        <div class="mb-3">
            <label for="grade_level" class="form-label">Série / Nível</label>
            <input type="text" name="grade_level" id="grade_level" class="form-control" placeholder="Ex: 9º Ano">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="active" selected>Ativa</option>
                <option value="inactive">Inativa</option>
            </select>
        </div>

        {{-- Botões --}}
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

{{-- Script para seleção automática do professor --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const defaultSelect = document.getElementById('default_subject');
        const newSubjectWrapper = document.getElementById('new_subject_name_wrapper');
        const teacherSelect = document.getElementById('teacher_id');

        function enableTeacherSelect() {
            teacherSelect.removeAttribute('disabled');
        }

        function disableTeacherSelect() {
            teacherSelect.setAttribute('disabled', true);
        }

        defaultSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const teacherId = selectedOption?.getAttribute('data-teacher') || '';
            const teacherName = selectedOption?.getAttribute('data-teacher-name') || '';

            if (this.value === 'new') {
                newSubjectWrapper.classList.remove('d-none');
                teacherSelect.value = '';
                enableTeacherSelect();
                return;
            }

            if (this.value === '') {
                newSubjectWrapper.classList.add('d-none');
                teacherSelect.value = '';
                enableTeacherSelect();
                return;
            }

            newSubjectWrapper.classList.add('d-none');

            if (teacherId) {
                let option = teacherSelect.querySelector(`option[value="${teacherId}"]`);
                if (!option) {
                    option = new Option(teacherName || `Professor #${teacherId}`, teacherId);
                    teacherSelect.appendChild(option);
                }
                teacherSelect.value = teacherId;
                teacherSelect.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
                disableTeacherSelect();
            } else {
                teacherSelect.value = '';
                enableTeacherSelect();
            }
        });
    });
</script>