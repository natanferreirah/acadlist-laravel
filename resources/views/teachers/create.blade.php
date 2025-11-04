<h1>Novo Professor</h1>

<form action="{{ route('teachers.store') }}" method="POST">
    @csrf

    <label>Nome:</label>
    <input type="text" name="name" value="{{ old('name') }}" required><br>

    <label>CPF:</label>
    <input type="text" name="cpf" maxlength="11" value="{{ old('cpf') }}" required><br>

    <label>Data de Nascimento:</label>
    <input type="date" name="birth_date" value="{{ old('birth_date') }}"><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required><br>

    <label>Telefone:</label>
    <input type="text" name="phone" maxlength="10" value="{{ old('phone') }}"><br>

    <label>Endereço:</label>
    <input type="text" name="address" value="{{ old('address') }}"><br>

    <label>Data de Contratação:</label>
    <input type="date" name="hire_date" value="{{ old('hire_date') }}"><br>

    <label>Status:</label>
    <select name="status">
        <option value="active">Ativo</option>
        <option value="inactive">Inativo</option>
    </select><br>

    <label>Qualificação:</label>
    <select name="qualification" required>
        @foreach($qualificationOptions as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select><br>

    <label>Matérias que Leciona:</label><br>
    <select name="subjects[]" multiple>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
        @endforeach
    </select><br>

    <button type="submit">Salvar</button>
</form>
