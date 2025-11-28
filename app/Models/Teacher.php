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

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value);
    }

     public function setTelefoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }

    public function getCpfFormatadoAttribute()
    {
        // LÊ DO BANCO: 12345678900
        // RETORNA: 123.456.789-00
        $cpf = $this->cpf;
        return substr($cpf, 0, 3) . '.' . 
               substr($cpf, 3, 3) . '.' . 
               substr($cpf, 6, 3) . '-' . 
               substr($cpf, 9, 2);
    }

    public static $qualificationOptions = [
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
