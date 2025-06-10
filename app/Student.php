<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'parent_id',
        'class_id',
        'roll_number',
        'gender',
        'phone',
        'dateofbirth',
        'current_address',
        'permanent_address',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function parent() 
    {
        return $this->belongsTo(Parents::class);
    }

    public function class() 
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }

    public function attendances() 
    {
        return $this->hasMany(Attendance::class);
    }

       /**
     * Obtenir l'emploi du temps de l'étudiant via sa classe
     */
    public function getSchedules($academicYear = null, $semester = null)
    {
        if (!$this->class_id) {
            return collect([]);
        }

        $academicYear = $academicYear ?: date('Y');
        $semester = $semester ?: '1';

        return Schedule::with(['subject', 'teacher.user'])
                      ->where('class_id', $this->class_id)
                      ->where('academic_year', $academicYear)
                      ->where('semester', $semester)
                      ->where('is_active', true)
                      ->orderBy('day_of_week')
                      ->orderBy('start_time')
                      ->get();
    }

}
