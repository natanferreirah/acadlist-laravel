<h1>Editar Matéria</h1>

<form action="{{ route('subjects.update', $subject) }}" method="POST">
@csrf @method('PUT')
<label>Nome:</label>
<input type="text" name="name" value="{{ old('name', $subject->name) }}" required><br>

<label>Código:</label>
<input type="text" name="code" value="{{ old('code', $subject->code) }}" required><br>

<label>Carga Horária:</label>
<input type="number" name="workload" value="{{ old('workload', $subject->workload) }}"><br>

<label>Série:</label>
<input type="text" name="grade_level" value="{{ old('grade_level', $subject->grade_level) }}"><br>

<label>Status:</label>
<select name="status">
<option value="active" {{ old('status', $subject->status) == 'active' ? 'selected' : '' }}>Ativo</option>
<option value="inactive" {{ old('status', $subject->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
</select><br>

<input type="submit" value="Atualizar">
</form>
