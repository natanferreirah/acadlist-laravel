<div class="container mt-4">
    <h2>Editar Professor</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $teacher->name }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" maxlength="11" value="{{ $teacher->cpf }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="birth_date" class="form-label">Data de Nascimento</label>
                <input type="date" name="birth_date" class="form-control" value="{{ $teacher->birth_date }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ $teacher->email }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" name="phone" class="form-control" value="{{ $teacher->phone }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="address" class="form-label">Endereço</label>
                <input type="text" name="address" class="form-control" value="{{ $teacher->address }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="hire_date" class="form-label">Data de Contratação</label>
                <input type="date" name="hire_date" class="form-control" value="{{ $teacher->hire_date }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="qualification" class="form-label">Formação</label>
                <select name="qualification" id="qualification" class="form-select">
                    <option value="">Selecione...</option>
                    @foreach (App\Models\Teacher::$qualificationLabels as $key => $label)
                    <option value="{{ $key }}" {{ old('qualification', $teacher->qualification ?? '') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Matéria --}}
        <div class="mb-3">
            <label for="subject_name" class="form-label">Matéria</label>
            <select name="subject_name" id="subject_name" class="form-select" onchange="toggleNewSubjectField()">
                <option value="">Manter atual ({{ $teacher->subjects->first()->name ?? 'Sem matéria' }})</option>
                @foreach($defaultSubjects as $subject)
                <option value="{{ $subject }}">{{ $subject }}</option>
                @endforeach
                <option value="new">Outra (criar nova)</option>
            </select>
        </div>

        <div class="mb-3" id="new_subject_field" style="display:none;">
            <label for="new_subject_name" class="form-label">Nova Matéria</label>
            <input type="text" name="new_subject_name" id="new_subject_name" class="form-control">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" @selected($teacher->status == 'active')>Ativo</option>
                <option value="inactive" @selected($teacher->status == 'inactive')>Inativo</option>
                <option value="on_leave" @selected($teacher->status == 'on_leave')>Em Licença</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    function toggleNewSubjectField() {
        const select = document.getElementById('subject_name');
        const field = document.getElementById('new_subject_field');
        field.style.display = select.value === 'new' ? 'block' : 'none';
    }
</script>