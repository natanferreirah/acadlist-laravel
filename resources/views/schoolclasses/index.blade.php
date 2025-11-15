<x-app-layout>

<body>
      <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Turmas
            </h2>
        </x-slot>
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
</x-app-layout>
