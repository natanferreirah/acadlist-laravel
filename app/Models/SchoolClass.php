<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'assigned_room',
        'shift',
        'grade',
        'school_year',
        'series',
        'weekly_workload_limit'
    ];

    public static $shiftOptions = [
        'morning' => 'Manhã',
        'afternoon' => 'Tarde',
        'night' => 'Noturno',
        'full' => 'Integral',
    ];

    public function getShiftLabelAttribute()
    {
        return self::$shiftOptions[$this->shift] ?? 'Desconhecido';
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'school_class_subject')
            ->withPivot('teacher_id', 'workload')
            ->withTimestamps();
    }

    public function currentWeeklyWorkload()
    {
        return $this->subjects()->sum('school_class_subject.workload');
    }
}
