<h1>Cadastrar Matéria</h1>

<form action="{{ route('subjects.store') }}" method="POST">
@csrf
<label>Nome:</label>
<input type="text" name="name" value="{{ old('name') }}" required><br>

<label>Código:</label>
<input type="text" name="code" value="{{ old('code') }}" required><br>

<label>Carga Horária:</label>
<input type="number" name="workload" value="{{ old('workload') }}"><br>

<label>Série:</label>
<input type="text" name="grade_level" value="{{ old('grade_level') }}"><br>

<label>Status:</label>
<select name="status">
<option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Ativo</option>
<option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
</select><br>

<input type="submit" value="Cadastrar">
</form>
