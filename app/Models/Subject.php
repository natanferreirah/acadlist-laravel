<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'workload',
        'grade_level',
        'status'
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

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class)
                    ->withPivot('school_class_id') // registra para qual turma
                    ->withTimestamps();
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class)
            ->withPivot('teacher_id')
            ->withTimestamps();
    }
}
