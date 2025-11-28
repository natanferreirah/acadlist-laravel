<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'workload',
        'department',
        'status',
    ];

    public static $defaultSubjects = [
        'Língua Portuguesa',
        'Literatura',
        'Inglês',
        'Espanhol',
        'Arte',
        'Educação Física',
        'Matemática',
        'Ciências',
        'Física',
        'Química',
        'Biologia',
        'História',
        'Geografia',
        'Filosofia',
        'Sociologia',
        'Ensino Religioso',
        'Projeto de Vida',
        'Empreendedorismo'
    ];

    public static $statusOptions = [
        'active' => 'Ativo',
        'inactive' => 'Inativo',
    ];

    public static $departmentOptions = [
        'technical course' => 'Curso Técnico',
        'exact' => 'Exatas',
        'humanities_science' => 'Ciências Humanas',
        'natural_science' => 'Ciências da Natureza',
        'languages' => 'Linguagens'
    ];

    public function getDepartmentOptionsAttribute()
    {
        return self::$departmentOptions[$this->department] ?? 'Desconhecido';
    }
    // Accessor: atributo virtual status_label
    public function getStatusLabelAttribute()
    {
        return self::$statusOptions[$this->status] ?? 'Desconhecido';
    }

    public function getDisplayNameAttribute()
    {
        return in_array($this->name, self::$defaultSubjects)
            ? $this->name
            : $this->name;
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_subject')
            ->withPivot('teacher_id', 'workload')
            ->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
