<h1>Editar Professor</h1>

<form action="{{ route('teachers.update', $teacher) }}" method="POST">
@csrf @method('PUT')
<label>Nome:</label>
<input type="text" name="name" value="{{ old('name', $teacher->name) }}" required><br>

<label>CPF:</label>
<input type="text" name="cpf" value="{{ old('cpf', $teacher->cpf_formatado) }}" required><br>

<label>Data Nasc.:</label>
<input type="date" name="birth_date" value="{{ old('birth_date', $teacher->birth_date_formatted) }}" required><br>

<label>Email:</label>
<input type="email" name="email" value="{{ old('email', $teacher->email) }}" required><br>

<label>Matérias:</label>
<select name="subjects[]">
@foreach($subjects as $subject)
    <option value="{{ $subject->id }}"
        {{ $teacher->subjects->contains($subject->id) ? 'selected' : '' }}>
        {{ $subject->name }}
    </option>
@endforeach
</select>

<input type="submit" value="Atualizar">
</form>
