<h1>Professores</h1>
<a href="{{ route('teachers.create') }}">+ Novo Professor</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>Data Nasc.</th>
        <th>Email</th>
        <th>Matérias</th>
    </tr>

    @foreach($teachers as $teacher)
    <tr>
        <td>{{ $teacher->name }}</td>
        <td>{{ $teacher->cpf_formatado }}</td>
        <td>{{ $teacher->birth_date_formatted }}</td>
        <td>{{ $teacher->email }}</td>
        <td>
            @foreach($teacher->subjects as $subject)
            {{ $subject->name }}<br>
            @endforeach
        </td>
        <td>
            <a href="{{ route('teachers.edit', $teacher) }}">Editar</a>
            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Excluir</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>