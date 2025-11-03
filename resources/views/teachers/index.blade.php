<div class="container mt-4">
    <h2>Professores Cadastrados</h2>

    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Novo Professor</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($teachers->isEmpty())
    <p>Nenhum professor cadastrado.</p>
    @else
    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Data Nasc.</th>
                <th>Data Contratação</th>
                <th>Formação</th>
                <th>Matéria</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->id }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->cpf }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->phone ?? '—' }}</td>
                <td>{{ $teacher->address ?? '—' }}</td>
                <td>{{ $teacher->birth_date }}</td>
                <td>{{ $teacher->hire_date ?? '—' }}</td>
                <td> {{ $teacher->qualification_label }}</td>
                <td>{{ $teacher->subjects->first()->name ?? 'Sem matéria' }}</td>
                <td>
                    @if($teacher->status == 'active')
                    <span class="badge bg-success">Ativo</span>
                    @elseif($teacher->status == 'inactive')
                    <span class="badge bg-secondary">Inativo</span>
                    @else
                    <span class="badge bg-warning text-dark">Em Licença</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este professor?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>