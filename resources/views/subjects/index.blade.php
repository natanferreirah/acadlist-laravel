
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Matérias</h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ Nova Matéria</a>
    </div>

    {{-- Mensagens de sucesso/erro --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        // Exibe apenas as matérias criadas pelo usuário (não-padrão)
        $userSubjects = $subjects->where('is_default', false);
    @endphp

    @if ($userSubjects->isEmpty())
        <div class="alert alert-warning">Nenhuma matéria cadastrada ainda.</div>
    @else
        <table class="table table-bordered align-middle text-center table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>Professor</th>
                    <th>Carga Horária</th>
                    <th>Série / Nível</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userSubjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->code ?? '—' }}</td>
                        <td>{{ $subject->teacher->name ?? 'Sem professor' }}</td>
                        <td>{{ $subject->workload ?? '—' }}</td>
                        <td>{{ $subject->grade_level ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $subject->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $subject->status === 'active' ? 'Ativa' : 'Inativa' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta matéria?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
