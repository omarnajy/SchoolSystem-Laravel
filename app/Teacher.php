<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'phone',
        'dateofbirth',
        'current_address',
        'permanent_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }

    public function classes()
    {
        return $this->hasMany(Grade::class);
    }

    public function allClasses()
    {
        return $this->belongsToMany(Grade::class, 'grade_teacher')
                   ->withPivot('is_main_teacher')
                   ->withTimestamps();
    }

    public function mainClasses()
    {
        return $this->belongsToMany(Grade::class, 'grade_teacher')
                   ->wherePivot('is_main_teacher', true);
    }

    public function secondaryClasses()
    {
        return $this->belongsToMany(Grade::class, 'grade_teacher')
                   ->wherePivot('is_main_teacher', false);
    }

    public function students() 
    {
        return $this->classes()->withCount('students');
    }

     /**
     * Relation avec les emplois du temps
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Obtenir l'emploi du temps actuel de l'enseignant
     */
    public function getCurrentSchedules($academicYear = null, $semester = null)
    {
        $academicYear = $academicYear ?: date('Y');
        $semester = $semester ?: '1';

        return $this->schedules()
                   ->with(['class', 'subject'])
                   ->where('academic_year', $academicYear)
                   ->where('semester', $semester)
                   ->where('is_active', true)
                   ->orderBy('day_of_week')
                   ->orderBy('start_time')
                   ->get();
    }

    /**
     * Obtenir les classes enseignées par cet enseignant
     */
    public function getClasses($academicYear = null, $semester = null)
    {
        $academicYear = $academicYear ?: date('Y');
        $semester = $semester ?: '1';

        return Grade::whereHas('schedules', function($query) use ($academicYear, $semester) {
            $query->where('teacher_id', $this->id)
                  ->where('academic_year', $academicYear)
                  ->where('semester', $semester)
                  ->where('is_active', true);
        })->get();
    }

    /**
     * Obtenir les matières enseignées par cet enseignant
     */
    public function getSubjects($academicYear = null, $semester = null)
    {
        $academicYear = $academicYear ?: date('Y');
        $semester = $semester ?: '1';

        return Subject::whereHas('schedules', function($query) use ($academicYear, $semester) {
            $query->where('teacher_id', $this->id)
                  ->where('academic_year', $academicYear)
                  ->where('semester', $semester)
                  ->where('is_active', true);
        })->get();
    }

    /**
     * Vérifier si l'enseignant a un conflit d'horaire
     */
    public function hasScheduleConflict($dayOfWeek, $startTime, $endTime, $academicYear, $semester, $excludeScheduleId = null)
    {
        $query = $this->schedules()
                     ->where('day_of_week', $dayOfWeek)
                     ->where('academic_year', $academicYear)
                     ->where('semester', $semester)
                     ->where('is_active', true)
                     ->where(function($q) use ($startTime, $endTime) {
                         $q->whereBetween('start_time', [$startTime, $endTime])
                           ->orWhereBetween('end_time', [$startTime, $endTime])
                           ->orWhere(function($subQ) use ($startTime, $endTime) {
                               $subQ->where('start_time', '<=', $startTime)
                                    ->where('end_time', '>=', $endTime);
                           });
                     });

        if ($excludeScheduleId) {
            $query->where('id', '!=', $excludeScheduleId);
        }

        return $query->exists();
    }
}
