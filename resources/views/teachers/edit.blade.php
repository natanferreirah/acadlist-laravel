<div class="container mt-4">
    <h2>Editar Professor</h2>

<form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nome:</label>
    <input type="text" name="name" value="{{ old('name', $teacher->name) }}" required><br>

    <label>CPF:</label>
    <input type="text" name="cpf" value="{{ old('cpf', $teacher->cpf) }}" required><br>

    <label>Data de Nascimento:</label>
    <input type="date" name="birth_date" value="{{ old('birth_date', $teacher->birth_date) }}"><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email', $teacher->email) }}" required><br>

    <label>Telefone:</label>
    <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}"><br>

    <label>Endereço:</label>
    <input type="text" name="address" value="{{ old('address', $teacher->address) }}"><br>

    <label>Data de Contratação:</label>
    <input type="date" name="hire_date" value="{{ old('hire_date', $teacher->hire_date) }}"><br>

    <label>Status:</label>
    <select name="status">
        <option value="active" {{ $teacher->status === 'active' ? 'selected' : '' }}>Ativo</option>
        <option value="inactive" {{ $teacher->status === 'inactive' ? 'selected' : '' }}>Inativo</option>
    </select><br>

    <label>Qualificação:</label>
    <select name="qualification" required>
        @foreach($qualificationOptions as $key => $label)
            <option value="{{ $key }}" {{ $teacher->qualification === $key ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select><br>

    <label>Matérias que Leciona:</label><br>
    <select name="subjects[]" multiple>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ $teacher->subjects->contains($subject->id) ? 'selected' : '' }}>
                {{ $subject->name }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Salvar Alterações</button>
</form>
