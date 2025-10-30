<h1>Cadastrar Professor</h1>

<form action="{{ route('teachers.store') }}" method="POST">
@csrf
<label>Nome:</label>
<input type="text" name="name" value="{{ old('name') }}" required><br>

<label>CPF:</label>
<input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required><br>

<script>
const cpfInput = document.getElementById('cpf');

cpfInput.addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g,''); // remove tudo que não é número
    if(value.length > 11) value = value.slice(0,11);

    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

    this.value = value;
});
</script>

<label>Data Nasc.:</label>
<input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required><br>
</script>


<label>Email:</label>
<input type="email" name="email" value="{{ old('email') }}" required><br>

<label>Matérias:</label>
<select name="subjects[]">
@foreach($subjects as $subject)
    <option value="{{ $subject->id }}">{{ $subject->name }} - {{ $subject->code }}</option>
@endforeach
</select>

<input type="submit" value="Cadastrar">
</form>
