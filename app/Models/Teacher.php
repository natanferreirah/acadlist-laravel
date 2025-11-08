<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'email',
        'phone',
        'address',
        'hire_date',
        'status',
        'qualification'
    ];

    // Teacher.php
    public function getCpfFormatadoAttribute()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value); // remove tudo que não é número
    }

    public static $qualificationOptions = [
        'license' => 'Licenciatura',
        'bachelor' => 'Bacharelado',
        'postgraduate' => 'Pós-graduação',
        'master' => 'Mestrado',
        'doctorate' => 'Doutorado',
    ];

    // Muitos pra muitos: um professor ensina várias matérias
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
