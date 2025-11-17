<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'cpf',
        'birth_date',
        'email',
        'phone',
        'address',
        'hire_date',
        'status',
        'qualification',
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
        'technical course' => 'Curso Técnico',
        'licentiate' => 'Licenciatura',
        'bachelor' => 'Bacharelado',
        'postgraduate' => 'Pós-graduação',
        'master' => 'Mestrado',
        'doctorate' => 'Doutorado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com School
     */
    public function school()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * Relacionamento com Subjects (matérias)
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
