<div class="container mt-4">
    <h2>Editar Matéria</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nome da Matéria --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nome da Matéria</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="{{ old('name', $subject->name) }}">
        </div>

        {{-- Código --}}
        <div class="mb-3">
            <label for="code" class="form-label">Código</label>
            <input
                type="text"
                name="code"
                id="code"
                class="form-control"
                value="{{ old('code', $subject->code) }}">
        </div>

        {{-- Professor --}}
        <div class="mb-3">
            <label for="teacher_id" class="form-label">Professor</label>
            @if($subject->is_default)
            <input
                type="text"
                class="form-control"
                value="{{ $subject->teacher->name ?? '—' }}">
            @else
            <select name="teacher_id" id="teacher_id" class="form-select">
                <option value="">Selecione o professor...</option>
                @foreach($teachers as $teacher)
                <option
                    value="{{ $teacher->id }}"
                    {{ $subject->teacher_id == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
                @endforeach
            </select>
            @endif
        </div>

        {{-- Carga Horária / Série / Status --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="workload" class="form-label">Carga Horária</label>
                <input
                    type="number"
                    name="workload"
                    id="workload"
                    class="form-control"
                    value="{{ old('workload', $subject->workload) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="grade_level" class="form-label">Série/Nível</label>
                <input
                    type="text"
                    name="grade_level"
                    id="grade_level"
                    class="form-control"
                    value="{{ old('grade_level', $subject->grade_level) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" {{ $subject->is_default ? 'disabled' : '' }}>
                    <option value="active" {{ $subject->status == 'active' ? 'selected' : '' }}>Ativa</option>
                    <option value="inactive" {{ $subject->status == 'inactive' ? 'selected' : '' }}>Inativa</option>
                </select>
                @if($subject->is_default)
                <input type="hidden" name="status" value="{{ $subject->status }}">
                @endif
            </div>
        </div>

        {{-- Botão --}}
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>