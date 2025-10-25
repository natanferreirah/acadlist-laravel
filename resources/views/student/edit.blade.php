<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Atualização</title>
</head>
<body>
    
    <form action="{{ route('students.update', $student->id) }}" method="post">
        @method('put')
        @csrf
        <input type="hidden" name="id">
        <label for="name">Nome:</label>
            <input type="text" name="name" id="" value="{{ $student->name }}">
        <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="{{ $student->cpf }}">
        <label for="birth_date">Data de Nascimento:</label>
            <input type="date" name="birth_date" id="" value="{{ $student->birth_date }}">
        <input type="submit" value="Atualizar">
    </form>
    
    <script>
        document.getElementById('cpf').addEventListener('input', function(e) {
            var value = e.target.value;
            var cpfPattern = value.replace(/\D/g, '') // Remove qualquer coisa que não seja número
                                    .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona ponto após o terceiro dígito
                                    .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona ponto após o sexto dígito
                                    .replace(/(\d{3})(\d)/, '$1-$2') // Adiciona traço após o nono dígito
                                    .replace(/(-\d{2})\d+?$/, '$1'); // Impede entrada de mais de 11 dígitos
            e.target.value = cpfPattern;
        });
    </script>
</body>
</html>