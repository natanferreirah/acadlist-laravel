<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name', 'code', 'description', 'workload', 'grade_level', 'status'
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
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }
}

