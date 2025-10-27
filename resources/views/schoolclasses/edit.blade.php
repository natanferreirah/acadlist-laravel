<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Atualização</title>
</head>
<body>
    
    <form action="{{ route('school-classes.update', $schoolClass->id) }}" method="post">
        @method('put')
        @csrf

        <label for="name">Nome:</label>
        <input type="text" name="name" value="{{ $schoolClass->name }}" required>

        <label for="assigned_room">Sala Atribuída:</label>
        <input type="text" name="assigned_room" value="{{ $schoolClass->assigned_room }}" required>

        <label for="grade">Série:</label>
        <input type="text" name="grade" value="{{ $schoolClass->grade }}" required>

        <label for="school_year">Ano escolar:</label>
        <input type="number" name="school_year" value="{{ $schoolClass->school_year }}" required>

        <label for="shift">Turno:</label>
        <select name="shift" id="shift" required>
            @foreach(\App\Models\SchoolClass::$shiftOptions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select> 
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>