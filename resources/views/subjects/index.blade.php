@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Matérias</h1>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ Nova Matéria</a>

    @if(session('success'))
    <div style="color: green; margin-top: 10px;">{{ session('success') }}</div>
    @endif

    <table cellpadding="10" cellspacing="0" width="800px" style="margin-top: 20px; border-collapse: collapse; text-align: center; border: 1px solid black;">
        <thead style="border: 1px solid black">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Código</th>
                <th>Carga Horária</th>
                <th>Departamento</th>
                <th>Professores</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $subject)
            <tr style="border: 1px solid black">
                <td>{{ $subject->id }}</td>
                <td>{{ $subject->display_name }}</td>
                <td>{{ $subject->code }}</td>
                <td>{{ $subject->workload }}</td>
                <td>{{ $subject->department_options }}</td>
                <td>
                    @if($subject->teachers->isNotEmpty())
                    {{ $subject->teachers->pluck('name')->join(', ') }}
                    @else
                    —
                    @endif
                </td>
                <td>{{ $subject->status_label}}</td>
                <td>
                    <a href="{{ route('subjects.edit', $subject) }}">Editar</a> |
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Tem certeza?')" style="color:red; background:none; border:none; cursor:pointer;">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" align="center">Nenhuma matéria cadastrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection