<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'class_name',
        'class_numeric',
        'teacher_id',
        'class_description'
    ];

    public function students()
    {
        return $this->hasMany(Student::class,'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function teacher() 
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relation avec les emplois du temps
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    /**
     * Obtenir l'emploi du temps actuel
     */
    public function getCurrentSchedules($academicYear = null, $semester = null)
    {
        $academicYear = $academicYear ?: date('Y');
        $semester = $semester ?: '1';

        return $this->schedules()
                   ->with(['subject', 'teacher.user'])
                   ->where('academic_year', $academicYear)
                   ->where('semester', $semester)
                   ->where('is_active', true)
                   ->orderBy('day_of_week')
                   ->orderBy('start_time')
                   ->get();
    }
}
