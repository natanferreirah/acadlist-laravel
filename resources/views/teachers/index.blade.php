<h1>Professores</h1>

<a href="{{ route('teachers.create') }}">Novo Professor</a>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Qualificação</th>
            <th>Status</th>
            <th>Matérias</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{$qualificationOptions[$teacher->qualification] ?? $teacher->qualification}}</td>
                <td>{{ $teacher->status === 'active' ? 'Ativo' : 'Inativo' }}</td>
                <td>
                    @forelse($teacher->subjects as $subject)
                        {{ $subject->name }}@if(!$loop->last), @endif
                    @empty
                        Nenhuma
                    @endforelse
                </td>
                <td>
                    <a href="{{ route('teachers.edit', $teacher->id) }}">Editar</a> |
                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Excluir este professor?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
