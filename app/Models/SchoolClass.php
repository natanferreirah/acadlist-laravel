<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'assigned_room',
        'shift',
        'school_year',
        'grade',
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
}
