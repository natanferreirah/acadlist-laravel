<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'workload',
        'grade_level',
        'status',
        'teacher_id',
        'is_default',
    ];

    public static $statusOptions = [
        'active' => 'Ativo',
        'inactive' => 'Inativo',
    ];

    // Accessor: atributo virtual status_label
    public function getStatusLabelAttribute()
    {
        return self::$statusOptions[$this->status] ?? 'Desconhecido';
    }

    // Muitos pra muitos: uma matéria tem vários professores
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class);
    }


    public static function defaultSubjects()
    {
        return [
            'Matemática',
            'Português',
            'História',
            'Química',
            'Física',
            'Biologia',
            'Educação Religiosa',
            'Geografia',
            'Ciências',
            'Inglês',
            'Artes',
            'Educação Física',
        ];
    }
}
