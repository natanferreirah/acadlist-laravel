<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acadlist - Alunos</title>
</head>

<body>
    <h1>Alunos</h1>
    <a href="{{route('students.create')}}">Cadastrar</a>
    @foreach($students as $student)
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Turma</th>
            <th>Série</th>
            <th>Turno</th>
        </tr>
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->cpf }}</td>
            <td>{{ $student->birth_date }}</td>
            <td>{{ $student->schoolclass->name ?? 'Sem turma'}}</td>
            <td>{{ $student->schoolclass->grade ?? '-'}}</td>
            <td>{{ $student->schoolclass->shift_label ?? '-'}}</td>
            <td><a href="{{route('students.edit', $student->id)}}">Editar</a></td>
            <td>
                <form action="{{ route('students.destroy', $student->id) }}" method="post">
                    @method('delete')
                    @csrf
                    <input type="submit" value="Excluír" onclick="return confirm('Tem certeza que deseja excluír o aluno {{ $student->name }}?')">
                </form>
            </td>
        </tr>
    </table>
    @endforeach
</body>

</html>