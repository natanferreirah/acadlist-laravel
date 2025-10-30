<h1>Matérias</h1>
<a href="{{ route('subjects.create') }}">+ Nova Matéria</a>

<table border="1" cellpadding="5">
<tr>
<th>Nome</th>
<th>Código</th>
<th>Carga Horária</th>
<th>Série</th>
<th>Status</th>
<th>Professores</th>
<th>Ações</th>
</tr>

@foreach($subjects as $subject)
<tr>
<td>{{ $subject->name }}</td>
<td>{{ $subject->code }}</td>
<td>{{ $subject->workload }}h</td>
<td>{{ $subject->grade_level }}</td>
<td>{{ $subject->status_label }}</td>
<td>
@foreach($subject->teachers as $teacher)
{{ $teacher->name }}<br>
@endforeach
</td>
<td>
<a href="{{ route('subjects.edit', $subject) }}">Editar</a>
<form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline;">
@csrf @method('DELETE')
<button type="submit">Excluir</button>
</form>
</td>
</tr>
@endforeach
</table>
