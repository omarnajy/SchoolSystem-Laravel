<?php
// app/Schedule.php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $fillable = [
        'class_id',
        'subject_id', 
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
        'academic_year',
        'semester',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean'
    ];

    // Relations
    public function class()
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Accesseurs
    public function getFormattedStartTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('H:i');
    }

    public function getFormattedEndTimeAttribute()
    {
        return Carbon::parse($this->end_time)->format('H:i');
    }

    public function getDayNameAttribute()
    {
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi', 
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi'
        ];
        
        return $days[$this->day_of_week] ?? $this->day_of_week;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    public function scopeForSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeForClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeForDay($query, $day)
    {
        return $query->where('day_of_week', $day);
    }

    // Méthodes utilitaires
    public static function getDaysOfWeek()
    {
        return [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi', 
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi'
        ];
    }

    public static function getTimeSlots()
    {
        return [
            '08:00' => '08:00',
            '08:30' => '08:30',
            '09:00' => '09:00',
            '09:30' => '09:30',
            '10:00' => '10:00',
            '10:30' => '10:30',
            '11:00' => '11:00',
            '11:30' => '11:30',
            '12:00' => '12:00',
            '12:30' => '12:30',
            '13:00' => '13:00',
            '13:30' => '13:30',
            '14:00' => '14:00',
            '14:30' => '14:30',
            '15:00' => '15:00',
            '15:30' => '15:30',
            '16:00' => '16:00',
            '16:30' => '16:30',
            '17:00' => '17:00',
            '17:30' => '17:30',
            '18:00' => '18:00'
        ];
    }

    // Vérifier les conflits d'horaires
    public function hasConflict()
    {
        return self::where('class_id', $this->class_id)
            ->where('day_of_week', $this->day_of_week)
            ->where('academic_year', $this->academic_year)
            ->where('semester', $this->semester)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                      ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                      ->orWhere(function($q) {
                          $q->where('start_time', '<=', $this->start_time)
                            ->where('end_time', '>=', $this->end_time);
                      });
            })
            ->when($this->exists, function($query) {
                $query->where('id', '!=', $this->id);
            })
            ->exists();
    }

    // Vérifier les conflits pour l'enseignant
    public function hasTeacherConflict()
    {
        return self::where('teacher_id', $this->teacher_id)
            ->where('day_of_week', $this->day_of_week)
            ->where('academic_year', $this->academic_year)
            ->where('semester', $this->semester)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                      ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                      ->orWhere(function($q) {
                          $q->where('start_time', '<=', $this->start_time)
                            ->where('end_time', '>=', $this->end_time);
                      });
            })
            ->when($this->exists, function($query) {
                $query->where('id', '!=', $this->id);
            })
            ->exists();
    }
}