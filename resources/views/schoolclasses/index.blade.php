<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acadlist - Turmas</title>
</head>
<body>
    <h1>Turmas</h1>
    <a href="{{route('school-classes.create')}}">Cadastrar</a>
    @foreach($schoolclasses as $s)
        <table style="text-align: center; border: 1px solid black; border-collapse: collapse; width: 800px;">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sala Atribuída</th>
                <th>Série</th>
                <th>Ano Letivo</th>
                <th>Turno</th>
            </tr>
            <tr>
                <td> {{ $s->id }}</td>
                <td>{{ $s->name }}</td>
                <td>{{ $s->assigned_room }}</td>
                <td>{{ $s->grade }}</td>
                <td>{{ $s->school_year }}</td>
                <td>{{ $s->shift_label }}</td>
                <td><a href="{{route('school-classes.edit', $s->id)}}">Editar</a></td>
                <td>
                    <form action="{{ route('school-classes.destroy', $s->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <input type="submit" value="Excluír" onclick="return confirm('Tem certeza que deseja')">
                    </form>
                </td>
            </tr>
        </table>
    @endforeach
</body>
</html>