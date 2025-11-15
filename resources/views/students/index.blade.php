<x-app-layout>
    <body>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alunos
            </h2>
        </x-slot>
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
                <td>{{ $student->cpf_formatado }}</td>
                <td>{{ $student->birth_date }}</td>
                <td>{{ $student->schoolClass->name ?? 'Sem turma'}}</td>
                <td>{{ $student->schoolClass->grade ?? '-'}}</td>
                <td>{{ $student->schoolClass->shift_label ?? '-'}}</td>
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
</x-app-layout>